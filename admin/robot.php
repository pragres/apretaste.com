<?php

/**
 */
$send = post('btnSend');

if (! is_null($send) || !is_null(get('subject'))) {
	
	ob_start();
	
	$robot = new ApretasteEmailRobot(false, false, false);
	
	$announce = array();
	$from = post('from');
	$headers = new stdClass();
	$headers->from = array(
			new stdClass()
	);
	if (is_null($from)) {
		$from = 'user@email.com';
		$headers->from[0]->mailbox = 'user';
		$headers->from[0]->host = 'email.com';
	} else {
		$headers = new stdClass();
		$headers->from = array(
				new stdClass()
		);
		$headers->from[0]->mailbox = substr($from, 0, strpos($from, '@'));
		$headers->from[0]->host = substr($from, strpos($from, '@') + 1);
	}
	$headers->fromaddress = $from;
	$headers->subject = post('subject');
	$htmlBody = post('body');
	if (is_null($headers->subject))
		$headers->subject = get('subject');
	if (is_null($htmlBody))
		$htmlBody = get('body');
	$txtBody = $htmlBody;
	$images = array();
	$callback = $robot->callback;
	
	$r = $callback($headers, $txtBody, $htmlBody, $images, false, null, false);
	$data['responses'] = $r;
	foreach ( $r as $k => $resp ) {
		$resp->_buildMessage();
		$html = utf8_encode($resp->message->getHTMLBody());
		
		foreach ( $resp->message->_html_images as $img ) {
			$html = str_replace("cid:" . $img['cid'], 'data:' . $img['c_type'] . ";base64," . base64_encode($img['body']), $html);
		}
		
		$html = str_replace('mailto:' . $resp->config['reply_to']. '?', 'index.php?path=admin&page=robot&', $html);
		
		$data['responses'][$k]->responseHTML = $html;
	}
	
	$cli = ob_get_contents();
	$data['logs'] = $cli;
	
	ob_end_clean();
}