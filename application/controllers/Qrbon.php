<?php

class Qrbon extends CI_Controller {
    public function test($test) {
        echo "Hallo Welt";
        var_dump($test);
    }
    public function speichern() {
        
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
        var_dump($decode->date);
        
        var_dump($this->input->post());
    }
}