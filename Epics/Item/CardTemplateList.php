<?php
declare(strict_types = 1);

namespace Epics\Item;
use Epics\EpicsList;

class CardTemplateList extends EpicsList { 
	
	protected $endpoint = EPICS__API_ENDPOINT . 'collections';
	protected $cacheKey = 'collection_cardtemplates_';
	private $collectionId;

	public function __construct(int $collectionId, bool $setTreatment = true, bool $init = true) {
		$this->endpoint = $this->endpoint . '/' . $collectionId . '/card-templates';
		$this->cacheKey = $this->cacheKey . $collectionId;
		parent::__construct($init, $this->cacheKey);

	}

	public function add(array $item) : CardTemplate {
		$item = new CardTemplate($item);
		$this->items[] = $item;
		return $item;
	}

	public function cacheRaw() : array {
		$data = parent::cacheRaw();
		return $data;
	}
}