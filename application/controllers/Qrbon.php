<?php

class Qrbon extends CI_Controller {
    public function test($test) {
        //echo "Hallo Welt";
        var_dump($test);
    }
    public function speichern() {
        $this->load->helper("db_functions");
        $db_functions = new db_functions();
        
        $text = '{
	"date":"2016-06-18T00:10:15Z",
	"store":"Mustermarkt Teststr. -100",
	"items":[
		{"name":"Vergoldeter Apfel", "price":100, "amount":1, "ean":"0000000000001", "tax":7},
		{"name":"Versilberter Apfel", "price":50, "amount":5, "ean":"0000000000002", "tax":19},
		{"name":"Verkupferter Apfel", "price":10, "amount":9, "ean":"0000000000003", "tax":19}
	]
}';
        $decode = json_decode($text);
        
        $date = $decode->date;
        $store = $decode->store;
        
        $p_id = $db_functions->save_purchase($date, $store);
        
        var_dump($p_id);
        
        if($p_id === NULL) {
            
            
        } else {
        
            foreach($decode->items as $item) {

                $name = $item->name;
                $price = $item->price;
                $amount = $item->amount;
                $ean = $item->ean;
                $tax = $item->tax;

                $db_functions->save_items($p_id, $name, $price, $amount, $ean, $tax);
            }
        
        }
        //var_dump($this->input->post());
    }
    public function anzeigen($id) {
        $this->load->helper("db_functions");
        $db_functions = new db_functions();
        
        $einkauf = $db_functions->get_purchase($id);
        $einkauf["items"] = $db_functions->get_items($id);
        var_dump(json_encode($einkauf));
    }
}