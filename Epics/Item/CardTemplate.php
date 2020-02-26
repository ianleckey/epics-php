<?php

namespace Epics\Item;

class CardTemplate extends Item {
	
	protected $title;
	protected $cardType;
	protected $categoryId;
	protected $treatmentId;
	protected $properties;

	public function __construct(int $id) {
		$this->id = $id;
	}


}
