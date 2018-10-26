<?php
namespace MuhBayu\KaskusHT;

interface KaskusHTInterface {
 
	public function hotthread();
	public function cURL($uri);
	function isArray($object);
	function isJson($pretty);
 
}
?>