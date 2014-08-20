<?php
$phrase = post('edtSearch', '');
$phrase = str_replace("'", "''", $phrase);

$data['searchresults'] = array();

if (strlen(trim($phrase)) >= 3) {
	$sql = "
	SELECT id, full_name, email, phone, date_registered, to_char(last_recharge, 'DD/MM/YYYY HH12:MI PM') as last_recharge 
	FROM (
		SELECT *, strpos(email || ' ' || full_name || ' ' || phone, '$phrase') AS pos,
		(select max(moment) 
		 FROM agency_recharge 
		 WHERE agency_customer.id = agency_recharge.customer) as last_recharge	
		FROM agency_customer
	) AS subq 
	WHERE pos > 0
	ORDER BY pos
	LIMIT 20;";
	
	$r = Apretaste::query($sql);
	if (isset($r[0])) {
		
		foreach ( $r as $k => $v ) {
			$r[$k] = array_merge(Apretaste::getAuthor($v['email'], false, 50), $v);
		}
		
		$data['searchresults'] = $r;
		
		echo new ApretasteView("../tpl/admin/agency.tpl", $data);
		exit();
	}
}

header("Location: index.php?path=admin&page=agency&customer_not_found=true");
