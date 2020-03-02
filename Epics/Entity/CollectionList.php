<?php

namespace Epics\Entity;
use Epics\Item\Card;
use Epics\Item\CardTemplate;
use Epics\Cache;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\Cache\ItemInterface;

class CollectionList implements iList {

	protected static $endpoint = EPICS__API_ENDPOINT . 'collections';

	/*protected $id;
	protected $name;
	protected $categoryId;
	protected $visible;
	protected $properties;
	protected $beta = null;
	protected $groupTreatments;
	protected $created;
	protected $updated;
	protected $images;*/

	protected $collections;

	public function __construct(bool $init = true) {
		if($init) {
			$cache = new Cache();
			$collections = $cache->pool->getItem('collections');
			if(!$collections->isHit()) {
				$collections->set( $this->cacheRaw() );
				$cache->pool->save($collections);
			}

			$allCollections = $collections->get();
			foreach($allCollections as $collection) {
				$this->add($collection);
			}
		}
	}	

	public function filter(string $type, $value) : self {
		$this->collections = array_filter(
		    $this->collections,
		    function ($e) use ($type, &$value) {
		        return $e->{$type} == $value;
		    }
		);
		return $this;
	}

	public function order(string $type, string $direction = 'asc') : self {
		usort($this->collections, function($a, $b) use ($type, $direction) {
			if($direction == 'desc') {
				return strtolower($b->{$type}) > strtolower($a->{$type});
			}
		    return strtolower($b->{$type}) < strtolower($a->{$type});
		});
		return $this;
	}

	public function result() : array {
		return $this->collections;
	}

	public function add(array $item) : Collection {
		$item = new Collection($item);
		$this->collections[] = $item;
		return $item;
	}

	public function count() : int {
		return count($this->collections);
	}

	public function cacheRaw() : array {
		$client = HttpClient::create();
		$headers = EPICS__HTTP_HEADERS;
		$cache = new Cache();
		$headers['X-User-JWT'] = $cache->get('jwt');
		$response = $client->request('GET', self::$endpoint, [ 
						'headers' => $headers,
						'query' => [
							'categoryId' => 1
						]
					]);
		if($response->getStatusCode() == 200) {
			$decodedPayload = $response->toArray();	
			return $decodedPayload['data'];
		}
	}
}