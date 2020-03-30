<?php 
declare(strict_types = 1);

namespace Epics\Entity;
use Epics\Image;
use Epics\Cache;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\Cache\ItemInterface;


class Team extends Entity {
	
	public static $endpoint = EPICS__API_ENDPOINT . 'teams';

	protected $cacheKey = 'team_';

	public $active = true;
	public $country;
	public $dob;
	public $shortName;
	public $manager;


	public function __construct(array $args = array()) {
		parent::__construct($args);
		$this->country = $args['country'] ?? null;
		$this->active = $args['active'] ?? true;
		$this->shortName = $args['shortName'] ?? '';
		$this->manager = $args['manager'] ?? 'N/A';
		$this->dob = $args['dob'] ?? '01-01-1970';
		return $this;
	}

	public function getPlayers() : array {
		$playersArr = [];
		$players = Player::getAllPlayers();
		foreach ($players as $player) { 
			if($player['playerFrames'][0]['teamId'] === $this->id) {
				$playersArr[] = new Player($player['id']);
			}
		}
		return $playersArr;
	}


	public static function getAllTeams() : array {
		
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
			return $decodedPayload['data']['teams'];
		}

	}

}

