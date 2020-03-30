<?php 
/**
* @package Epics
* @subpackage EpicsList
*
* @author Ian Leckey <ian.leckey@gmail.com>
*/
declare(strict_types = 1);

namespace Epics;

use Symfony\Component\HttpClient\HttpClient;
use Epics\Cache;
use Symfony\Contracts\Cache\ItemInterface;

class EpicsList {

	public $items;

	public function __construct(bool $init = true, string $cacheKey) {
		if($init) {
			$cache = new Cache();
			$items = $cache->pool->getItem( $cacheKey );
			if(!$items->isHit()) {
				$items->set( $this->cacheRaw() );
				$cache->pool->save($items);
			}

			$allItems = $items->get();
			foreach($allItems as $item) {
				$this->add($item);
			}
		}
	}

	/**
	* @param string $type property to filter
	* @param mixed $value 
	* @return EpicsList
	*/
	public function filter(string $type, $value) : self {
		$this->items = array_values(
							array_filter(
									$this->items,
							    function ($e) use ($type, &$value) {
							        return $e->{$type} == $value;
							    }
							)
						);
		return $this;
	}

	/**
	* @param string $type
	* @param string $direction
	* @return EpicsList
	*/
	public function order(string $type, string $direction = 'asc') : self {
		usort($this->items, function($a, $b) use ($type, $direction) {
			if($direction == 'desc') {
				if(is_int($b->{$type})) { 
					return $b->{$type} > $a->{$type};
				}
				return strtolower($b->{$type}) > strtolower($a->{$type});
			} else {
				if(is_int($b->{$type})) { 
					return $b->{$type} < $a->{$type};
				}
			}
		    return strtolower($b->{$type}) < strtolower($a->{$type});
		});
		return $this;
	}

	public function first() {
		if($this->count() > 0) {
			return $this->items[0];
		}
	}

	public function last() {
		if($this->count() > 0) {
			return $this->items[$this->count() - 1];
		}
	}

	public function result() : array {
		return $this->items;
	}

	public function count() : int {
		return count($this->items);
	}

	public function cacheRaw() : array {
		$client = HttpClient::create();
		$headers = EPICS__HTTP_HEADERS;
		$cache = new Cache();
		$headers['X-User-JWT'] = $cache->get('jwt');
		$response = $client->request('GET', $this->endpoint, [ 
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
