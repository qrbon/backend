<?php

class Qrbon extends CI_Controller
{
	public function speichern()
	{
		$this->load->helper("db_functions");
		$db_functions = new db_functions();

		$data = $this->input->post('json');
		$data = json_decode($data);
		$date = $data->date;
		$store = $data->store;
		$p_id = $db_functions->save_purchase($date, $store);
		echo($p_id);
		if($p_id === NULL)
			;
		else {
		
			foreach($data->items as $item) {
				$name = $item->name;
				$price = $item->price;
				$amount = $item->amount;
				$ean = $item->ean;
				$tax = $item->tax;

				$db_functions->save_items($p_id, $name, $price, $amount, $ean, $tax);
			}
		
		}
	}

	public function anzeigen($id)
	{
		$this->load->helper("db_functions");
		$db_functions = new db_functions();
		
		$einkauf = $db_functions->get_purchase($id);
		$einkauf["items"] = $db_functions->get_items($id);
		echo json_encode($einkauf);
	}
}

?>
