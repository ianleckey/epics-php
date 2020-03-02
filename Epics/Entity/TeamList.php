<?php
declare(strict_types = 1);

namespace Epics\Entity;

class TeamList extends EpicsList { 
	
	protected static $endpoint = EPICS__API_ENDPOINT . 'teams';
	protected static $cacheKey = 'teams';

	public function __construct(bool $init = true) {
		parent::__construct($init, self::$cacheKey);
	}


	public function add(array $item) : Team {
		$item = new Team($item);
		$this->items[] = $item;
		return $item;
	}

	public function cacheRaw() : array {
		$data = parent::cacheRaw();
		return $data['teams'];
	}
}