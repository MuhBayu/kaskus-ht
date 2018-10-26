<?php
namespace MuhBayu;

require_once(__DIR__."/endpoint/endpoint.php");
require_once(__DIR__."/KaskusHTInterface.php");
require_once(__DIR__."/KaskusHTCache.php");
require_once(__DIR__."/htmldom/simple_html_dom.php");
/**
 * 
 */

use MuhBayu\KaskusHT\Traits\EndPoint;
use MuhBayu\KaskusHT\Cache;

class KaskusHT implements \MuhBayu\KaskusHT\KaskusHTInterface
{
	use EndPoint;
	protected $uri_kaskus = 'https://kaskus.co.id';
	protected $uri_kaskus_source = 'https://m.kaskus.co.id/forum/hotthread/';
	function __construct()
	{
		$this->cache = Cache::instance([]);
		// $this->htmldom = new simple_html_dom();
		$this->startScriptTime = microtime(TRUE);
	}
	function isArray($object=true) {
		if ($object) {
			return (object) $this->output;
		} else {
			return (array) $this->output;

		}
	}
	public function isJson($pretty=true) {
		header('Content-type:Application/Json');
		return json_encode($this->output, $pretty?JSON_PRETTY_PRINT:null);
	}
	public function cURL($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 150);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate'); // please compress data
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		// /curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		$result 	 = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  		$curl_errno  = curl_errno($ch);
  		if($curl_errno) {
  			// return Self::show_err($curl_errno);
  		}
		curl_close($ch);
		return $result;
	}

}