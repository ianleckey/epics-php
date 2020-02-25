<?php

namespace Epics\Item;

class CardTemplate extends Item {
	
	public $cardType;

	public function __construct(int $id) {
		$this->id = $id;
	}


}
