<?php
$name = post('edtSearchName');
$email = post('edtSearchEmail');
$phone = post('edtSearchPhone');

$email = Apretaste::extractEmailAddress($email);

$r = Apretaste::query("
		SELECT id FROM agency_customer 
		WHERE email ~* '$email' OR phone ~* '$phone' LIMIT 1;");

if (isset($r[0]))
	if (isset($r[0]['id'])) {
		header("Location: index.php?path=admin&page=agency_customer&id=" . $r[0]['id']);
		exit();
	}

header("Location: index.php?path=admin&page=agency&customer_not_found=true");
