<?php

$user = post('user');
$pass = post('pass');
$login = post('login');
$user = pg_escape_string($user);

$procede = true;

ApretasteAdmin::$login_result = false;

if ($procede) {
	if (! is_null($login)) {
		$error = true;
		$u = Apretaste::query("SELECT * FROM users WHERE user_login = '$user';");
		if (isset($u[0])) {
			$u = $u[0];
			if ($u['user_pass'] == md5($pass)) {
				$_SESSION['user'] = $u['user_login'];
				ApretasteAdmin::$login_result = true;
				$error = false;
			}
		}
	}
}

ApretasteAdmin::saveUserAction();

if (ApretasteAdmin::$login_result)
	header("Location: index.php?page=".ApretasteAdmin::getDefaultPage());
else
	header("Location: index.php?".($error?'&error=true':''));