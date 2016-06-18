<?php

 ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);


class db_functions
{
	private $dbconn;

	private function _pg_prepare($conn, $stmtname, $query)
	{
		if (pg_prepare($conn, $stmtname, $query) == FALSE)
			die('Could not create Query with name "' . $stmtname . '".');
	}

	function __construct()
	{
		$this->dbconn = pg_connect("host=localhost dbname=qrbon user=qrbon password=qrbon")
			or die('Verbindung zur Datenbank konnte nicht hergestellt werden: ' . pg_last_error());

		$this->_pg_prepare($this->dbconn, "save_purchase", "insert into purchase (id, date, store) values ($1, $2, $3) returning id");
		$this->_pg_prepare($this->dbconn, "get_purchase", "select date, store from purchase where id = $1");
		$this->_pg_prepare($this->dbconn, "save_items", "insert into items (p_id, name, price, amount, ean, tax) values ($1, $2, $3, $4, $5, $6) returning id");
		$this->_pg_prepare($this->dbconn, "get_item", "select p_id, name, price, amount, ean, tax from items where id = $1");
		$this->_pg_prepare($this->dbconn, "get_items", "select id, name, price, amount, ean, tax from items where p_id = $1");
	}

	private function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}

	public function save_purchase($date, $store)
	{
		$result = pg_execute($this->dbconn, "save_purchase", array($this->gen_uuid(), $date, $store));
		if ($line = pg_fetch_array($result))
			return $line['id'];
		else
			return NULL;
	}

	public function get_purchase($id)
	{
		$result = pg_execute($this->dbconn, "get_purchase", array($id));
		if ($line = pg_fetch_array($result))
			return array(
				'date' => $line['date'],
				'store' => $line['store']
			);
		else
			return NULL;
	}

	public function save_items($p_id, $name, $price, $amount, $ean, $tax)
	{
		$result = pg_execute($this->dbconn, "save_items", array($p_id, $name, $price, $amount, $ean, $tax));
		if ($line = pg_fetch_array($result))
			return $line['id'];
		else
			return NULL;
	}

	public function get_item($id)
	{
		$result = pg_execute($this->dbconn, "get_item", array($id));
		if ($line = pg_fetch_array($result))
			return array(
				"p_id" => $line['p_id'],
				"name" => $line['name'],
				"price" => $line['price'],
				"amount" => $line['amount'],
				"ean" => $line['ean'],
				"tax" => $line['tax']
			);
		else
			return NULL;
	}

	public function get_items($p_id)
	{
		$return_arr = array();
		$result = pg_execute($this->dbconn, "get_items", array($p_id));
		while ($line = pg_fetch_array($result))
			array_push($return_arr, array(
				"id" => $line['id'],
				"name" => $line['name'],
				"price" => $line['price'],
				"amount" => $line['amount'],
				"ean" => $line['ean'],
				"tax" => $line['tax']
			));
		return $return_arr;
	}

}

?>
