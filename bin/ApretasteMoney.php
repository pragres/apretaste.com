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
	 * Fixing credit precision
	 * TODO: research better solution
	 */
	static function fixCreditPrecision(){
		q("update credit set credit = round(credit::numeric,2) where credit::numeric <> round(credit::numeric,2);");
	}
	
	/**
	 * Returns the total of credits a user has
	 * @param unknown $email
	 * @return boolean number
	 */
	static function getCreditOf($email){
		self::fixCreditPrecision();
		
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
		$r = self::getDispatcher($email);
		
		if ($r == false) {
			Apretaste::query("INSERT INTO dispatcher (email,name,contact) VALUES ('$email','$name','$contact');");
			return true;
		}
		
		return false;
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
	
	/**
	 * Return the list of dispatchers
	 *
	 * @return array
	 */
	static function getDispatchers($pic_width=20){
		$r = Apretaste::query("SELECT *, 
				(select count(*) from recharge_card_sale WHERE dispatcher = email) as sales,
				coalesce((select total_sold from  dispatchers_owe where dispatchers_owe.dispatcher = dispatcher.email),0) as total_sold,
				coalesce((select profit from  dispatchers_owe where dispatchers_owe.dispatcher = dispatcher.email),0) as profit,
				coalesce((select owe from  dispatchers_owe where dispatchers_owe.dispatcher = dispatcher.email),0) as owe 
				FROM dispatcher;");
		if (! is_array($r))
			$r = array();
		
		foreach ( $r as $k => $v ) {
			$r[$k] = array_merge(Apretaste::getAuthor($v['email'], false, $pic_width), $v);
		}
		
		return $r;
	}
	
	/**
	 * Return a dispatcher
	 *
	 * @return array
	 */
	static function getDispatcher($email, $pic_width = 20){
		$r = Apretaste::query("SELECT *, (select count(*) from recharge_card_sale WHERE dispatcher = email) as sales,
				coalesce((select total_sold from  dispatchers_owe where dispatchers_owe.dispatcher = dispatcher.email),0) as total_sold,
				coalesce((select profit from  dispatchers_owe where dispatchers_owe.dispatcher = dispatcher.email),0) as profit,
				coalesce((select owe from  dispatchers_owe where dispatchers_owe.dispatcher = dispatcher.email),0) as owe
				FROM dispatcher 
				WHERE email = '$email';");
		
		if (! is_array($r))
			return false;
		
		$r[0] = array_merge(Apretaste::getAuthor($r[0]['email'], false, $pic_width), $r[0]);
		
		return $r[0];
	}
	static function getRechargeCardSalesOf($email){
		$r = Apretaste::query("SELECT sale_date, *, (select count(*) from recharge_card WHERE sale = id) as cards FROM recharge_card_sale WHERE dispatcher = '$email';");
		if (! is_array($r))
			$r = array();
		return $r;
	}
	
	/**
	 * Return a list of sale's cards
	 *
	 * @param string $id
	 * @return multitype:
	 */
	static function getSaleCards($id){
		$r = Apretaste::query("SELECT * FROm recharge_card WHERE sale= '$id';");
		if (! is_array($r))
			$r = array();
		return $r;
	}
	
	/**
	 * Delete a sale of cards
	 *
	 * @param string $id
	 */
	static function delSale($id){
		Apretaste::query("DELETE FROM recharge_card_sale WHERE id = '$id';");
	}
	
	/**
	 * Return the data of payment warning report
	 *
	 * @param string $email
	 * @return array
	 */
	static function getPaymentWarning($email){
		$dispatcher = self::getDispatcher($email);
		$cards = q("SELECT * FROM dispatchers_cards_without_pay WHERE dispatcher='$email' order by date;");
		
		$from_date = q("SELECT min(date) as d FROM dispatchers_cards_without_pay WHERE dispatcher='$email';");
		
		if (isset($from_date[0]))
			$from_date = $from_date[0]['d'];
		else
			$from_date = false;
		
		$to_date = q("SELECT min(date) as d FROM dispatchers_cards_without_pay WHERE dispatcher='$email';");
		
		if (isset($to_date[0]))
			$to_date = $to_date[0]['d'];
		else
			$to_date = false;
		
		return array(
				'dispatcher_email' => $dispatcher['email'],
				'dispatcher_name' => $dispatcher['name'],
				'owe' => $dispatcher['owe'],
				'from_date' => $from_date,
				'to_date' => $to_date,
				'cards' => $cards
		);
	}
}
