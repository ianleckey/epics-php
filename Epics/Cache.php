<?php

namespace Epics;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class Cache {
	
	public $expires = 86400;
	public $pool;
	protected static $poolNamespace = 'epics';
	protected static $poolDir = './cache/';
	protected static $poolDefaultExpires = 0;

	public function __construct() {
		$this->pool = new FilesystemAdapter(self::$poolNamespace, self::$poolDefaultExpires, self::$poolDir);
	}
	
	public function clear($type = false) {

		if($type) {
			$this->pool->deleteItem($type);
		} else {
			$this->pool->deleteItem('jwt');
			$this->pool->deleteItem('teams');
		}
		
	}

	public function get($type) {
		
		return $this->pool->getItem( $type )->get();

	}


}