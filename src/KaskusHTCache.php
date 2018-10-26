<?php

namespace MuhBayu\KaskusHT;

/**
 * 
 */
class Cache
{
	protected static $instances;
	protected static $time = 10*60;
	protected static $path_to = __DIR__.'/cache/';
	public static function instance() {
		if(Self::$instances === NULL) {
			Self::$instances = new Self;
		}
		return Self::$instances;
	}

	static function save($filename='', $string) {
		if(!Self::$instances instanceof Cache) return;
			$f = fopen(Self::$path_to."$filename.cache", 'w');
			fwrite ($f, serialize($string));
			fclose($f);
			return $f;
	}
	static function read($filename) {
		$path = Self::$path_to."$filename.cache";
		if (file_exists($path) && (time() - Self::$time <= filemtime($path))) {
			$f = fopen($path, 'r');
			$buffer = '';
			while(!feof($f)) {
				$buffer .= fread($f, 2048);
			}
			fclose($f);
			return unserialize($buffer);
		}
		return false;
	}
}