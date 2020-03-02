<?php 

namespace Epics\Entity;
use Symfony\Component\HttpClient\HttpClient;
use Epics\Cache;
use Symfony\Contracts\Cache\ItemInterface;

class EpicsList {

	protected $items;

	public function __construct(bool $init = true, $cacheKey) {
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

	public function filter(string $type, $value) : self {
		$this->items = array_filter(
		    $this->items,
		    function ($e) use ($type, &$value) {
		        return $e->{$type} == $value;
		    }
		);
		return $this;
	}

	public function order(string $type, string $direction = 'asc') : self {
		usort($this->items, function($a, $b) use ($type, $direction) {
			if($direction == 'desc') {
				return strtolower($b->{$type}) > strtolower($a->{$type});
			}
		    return strtolower($b->{$type}) < strtolower($a->{$type});
		});
		return $this;
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
