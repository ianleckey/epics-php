<?php
declare(strict_types = 1);

namespace Epics\Entity;
use Epics\EpicsList;
use Epics\Item\CardTemplate;

class CollectionList extends EpicsList {

	protected $endpoint = EPICS__API_ENDPOINT . 'collections';
	protected $cacheKey = 'collections';

	public function __construct(bool $init = true) {
		parent::__construct($init, $this->cacheKey);
	}

	public function add(array $item) : Collection {
		$item = new Collection($item);
		$this->items[] = $item;
		return $item;
	}
}