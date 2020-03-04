<?php
declare(strict_types = 1);

namespace Epics\Entity;
use Epics\EpicsList;

class PlayerList extends EpicsList { 
	
	protected $endpoint = EPICS__API_ENDPOINT . 'players';
	protected $cacheKey = 'players';

	public function __construct(bool $init = true) {
		parent::__construct($init, $this->cacheKey);
	}


	public function add(array $item) : Player {
		$item = new Player($item);
		$this->items[] = $item;
		return $item;
	}

	public function cacheRaw() : array {
		$data = parent::cacheRaw();
		return $data['players'];
	}
}