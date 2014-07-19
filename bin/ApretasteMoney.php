<?php

/**
 * Apretaste Money Management
 *
 * @author rafa <rafa@pragres.com>
 *        
 */
class ApretasteMoney {
	
	/**
	 * Recharge credit
	 *
	 * @param string $email
	 * @param float $amount
	 * @param string $code_redeemed
	 * @param string $payment_method
	 * @return boolean
	 */
	static function recharge($email, $amount, $code_redeemed = '', $payment_method = 'cc'){
		$amount = $amount * 1;
		
		$email = strtolower($email);
		
		Apretaste::query("INSERT INTO recharge (email,amount,code_redeemed,payment_method) VALUES
				('$email','$amount','$code_redeemed','$payment_method');");
		
		return true;
	}
	
	/**
	 * Returns the total of credits a user has
	 * @param unknown $email
	 * @return boolean number
	 */
	static function getCreditOf($email){
		$email = strtolower($email);
		
		$r = Apretaste::query("SELECT email, credit FROM credit WHERE email = '$email';");
		
		if (isset($r[0]))
			if (isset($r[0]['email']))
				if ($r[0]['email'] == $email)
					return $r[0]['credit'] * 1;
		
		return 0;
	}
	
	/**
	 * Return all discounts of a user
	 *
	 * @param string $email
	 * @param number $limit
	 * @param number $offset
	 * @return array
	 */
	static function getDiscountsOf($email, $limit = 100, $offset = 0){
		$email = strtolower($email);
		
		$r = Apretaste::query("SELECT * FROM discounts WHERE email = '$email';");
		
		return $r;
	}
	
	/**
	 * Add a new dispatcher
	 *
	 * @param string $email
	 * @param string $name
	 * @param string $contact
	 */
	static function addDispatcher($email, $name, $contact){
		Apretaste::query("INSERT INTO dispatcher (email,name,contact) VALUES ('$email','$name','$contact');");
	}
	
	/**
	 * Delete a dispatcher
	 *
	 * @param string $email
	 */
	static function delDispatcher($email){
		Apretaste::query("DELETE FROM dispatcher WHERE email = '$email';");
	}
	
	/**
	 * Update the dispatcher info
	 *
	 * @param string $email
	 * @param string $name
	 * @param string $contact
	 * @param string $newemail
	 */
	static function updateDispatcher($email, $name = null, $contact = null, $newemail = null){
		if (! is_null($name))
			Apretaste::query("update dispatcher SET name= '$name' WHERE email='$email';");
		if (! is_null($name))
			Apretaste::query("update dispatcher SET contact= '$contact' WHERE email='$email';");
		if (! is_null($newemail))
			Apretaste::query("update dispatcher SET email = '$newemail' WHERE email='$email';");
	}
	
	/**
	 * Add new sale of recharge cards
	 *
	 * @param string $dispatcher
	 * @param integer $quantity
	 * @param float $sale_price
	 * @param float $card_price
	 */
	static function addRechargeCardSale($dispatcher, $quantity, $sale_price, $card_price){
		$quantity *= 1;
		$sale_price *= 1;
		$card_price *= 1;
		$id = uniqid();
		Apretaste::query("INSERT INTO recharge_card_sale (id, dispatcher, quantity, sale_price, card_price)
				VALUES ('$id', '$dispatcher', $quantity, $sale_price, $card_price);");
	}
	static function getDispatchers(){
		$r = Apretaste::query("SELECT *, (select count(*) from recharge_card_sale WHERE dispatcher = email) as sales FROM dispatcher;");
		if (! is_array($r))
			$r = array();
		return $r;
	}
	static function getRechargeCardSalesOf($email){
		$r = Apretaste::query("SELECT *, (select count(*) from recharge_card WHERE sale = id) as cards FROM recharge_card_sale WHERE dispatcher = '$email';");
		if (! is_array($r))
			$r = array();
		return $r;
	}
	
	static function getSaleCards($id){
		$r = Apretaste::query("SELECT * FROm recharge_card WHERE sale= '$id';");
		if (! is_array($r))
			$r = array();
		return $r;
	}
	
	static function delSale($id){
		Apretaste::query("DELETE FROM recharge_card_sale WHERE id = '$id';");
		
	}
}
