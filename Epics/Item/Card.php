<?php 
namespace Epics\Item;

class Card extends Item {
	
	protected $cardTemplate;
	protected $mintNumber;
	protected $mintBatch;

	public function __construct(int $id) {
		$this->id = $id;
	}

	public function setCardTemplate(CardTemplate $cardTemplate) {
		$this->cardTemplate = $cardTemplate;
	}
}

