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

		$this->_pg_prepare($this->dbconn, "save_purchase", "insert into purchase (date, store) values ($1, $2) returning id");
		$this->_pg_prepare($this->dbconn, "get_purchase", "select (date, store) from purchase where id = $1");
		$this->_pg_prepare($this->dbconn, "save_items", "insert into items (p_id, name, price, amount, ean, tax) values ($1, $2, $3, $4, $5, $6) returning id");
		$this->_pg_prepare($this->dbconn, "get_item", "select (p_id, name, price, amount, ean, tax) from items where id = $1");
		$this->_pg_prepare($this->dbconn, "get_items", "select (id, name, price, amount, ean, tax) from items where p_id = $1");
	}

	public function save_purchase($date, $store)
	{
		$result = pg_execute($this->dbconn, "save_purchase", array($date, $store));
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
				"date" => $line['date'],
				"store" => $line['store']
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
