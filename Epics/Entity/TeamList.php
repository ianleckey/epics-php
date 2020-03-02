<?php

namespace Epics\Entity;
use Epics\Cache;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\Cache\ItemInterface;

class TeamList implements iList { 
	
	protected $teams;

	public function __construct(bool $init = true) {
		if($init) {
			$cache = new Cache();
			$teams = $cache->pool->getItem('teams');
			if(!$teams->isHit()) {
				$teams->set( $this->cacheRaw() );
				$cache->pool->save($teams);
			}

			$allTeams = $teams->get();
			foreach($allTeams as $team) {
				$this->add($team);
			}
		}
	}

	public function filter(string $type, $value) : self {
		$this->teams = array_filter(
		    $this->teams,
		    function ($e) use ($type, &$value) {
		        return $e->{$type} == $value;
		    }
		);
		return $this;
	}

	public function order(string $type, string $direction = 'asc') : self {
		usort($this->teams, function($a, $b) use ($type, $direction) {
			if($direction == 'desc') {
				return strtolower($b->{$type}) > strtolower($a->{$type});
			}
		    return strtolower($b->{$type}) < strtolower($a->{$type});
		});
		return $this;
	}

	public function result() : array {
		return $this->teams;
	}

	public function add(array $team) : Team {
		$team = new Team($team);
		$this->teams[] = $team;
		return $team;
	}

	public function count() : int {
		return count($this->teams);
	}

	public function cacheRaw() : array {
		$client = HttpClient::create();
		$headers = EPICS__HTTP_HEADERS;
		$cache = new Cache();
		$headers['X-User-JWT'] = $cache->get('jwt');
		$response = $client->request('GET', Team::$endpoint, [ 
						'headers' => $headers,
						'query' => [
							'categoryId' => 1
						]
					]);
		if($response->getStatusCode() == 200) {
			$decodedPayload = $response->toArray();	
			return $decodedPayload['data']['teams'];
		}
	}
}