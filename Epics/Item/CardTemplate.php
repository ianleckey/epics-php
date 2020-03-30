<?php

namespace Epics\Item;

class CardTemplate extends Item {
	
	public $title;
	protected $cardType;
	protected $categoryId = 1;
	protected $treatmentId;
	protected $properties;
	protected $limitedEdition = false;

	public function __construct(array $args, bool $setTreatment = true) {
		parent::__construct($args);
		$this->title = $args['title'];
		$this->cardType = $args['cardType'];
		$this->categoryId = $args['categoryId'];
		$this->treatmentId = $args['treatmentId'];
		$this->properties = $args['properties'];
		$this->images = $args['images'];
            
		$this->limitedEdition = $args['limitedEdition'];
		$this->inCirculation = $args['inCirculation'];
		$this->rarity = $args['rarity'];

		if($setTreatment)
        	$this->setTreatment( $args['treatment'] );

	}


	protected function setTreatment(array $treatment) {
		$this->treatment = $treatment;
	}

	protected function getMarketListings() : MarketListingList {
		return new MarketListingList($this->id);
	}

	public function getCirculation() : int {
		return $this->inCirculation;
	}

}
