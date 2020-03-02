<?php

namespace Epics\Entity;
use Epics\Item\Card;
use Epics\Item\CardTemplate;
use Epics\Cache;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\Cache\ItemInterface;

class CollectionList extends EpicsList {

	protected static $endpoint = EPICS__API_ENDPOINT . 'collections';
	protected static $cacheKey = 'collections';

	public function __construct(bool $init = true) {
		parent::__construct($init, self::$cacheKey);
	}

	public function add(array $item) : Collection {
		$item = new Collection($item);
		$this->items[] = $item;
		return $item;
	}
}