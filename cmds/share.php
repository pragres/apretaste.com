<?php
function cmd_share($robot, $from, $argument, $body = '', $images = array()){
	$argument = trim($argument);
	
	$friends = ApretasteSocial::getFriendsOf($from);
	
	foreach ( $friends as $friend ) {
		Apretaste::query("INSERT INTO shares (author, guest, sentence) VALUES 
					('$from','$friend','$argument');");
		
		$data = array(
				'command' => 'share',
				'answer_type' => 'share',
				"from" => $from,
				"guest" => $friend,
				"author" => $from,
				"sentence" => $argument,
				"title" => "$from a compartido algo contigo"
		);
		
		$config = array();
		
		foreach ( Apretaste::$robot->config_answer as $configx ) {
			$config = $configx;
			break;
		}
		
		$answerMail = new ApretasteAnswerEmail($config, $friend, Apretaste::$robot->smtp_servers, $data, true, true, false);
	}
	
	return array(
			'answer_type' => 'share_successfull',
			'command' => 'share',
			'sentence' => $argument,
			'title' => 'Compartido satisfactoriamente a tus amigos'
	)
	;
}