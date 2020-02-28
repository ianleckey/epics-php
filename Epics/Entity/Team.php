<?php 
namespace Epics\Entity;
use Epics\Image;
use Epics\Cache;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\Cache\ItemInterface;


class Team extends Entity {
	
	protected static $endpoint = EPICS__API_ENDPOINT . 'teams';

	public $shortName;
	public $manager;

	public function __construct(int $id = 0) {
		if($id > 0) {

			$cache = new Cache();
			$teams = $cache->pool->getItem('teams');

			if(!$teams->isHit()) {
				$teams->set($this->getAllTeams());
				$cache->pool->save($teams);
			}
			
			$allTeams = $teams->get();

			foreach($allTeams as $team) {
				if($team['id'] === $id) {
					$this->id = $id;
					$this->country = $team['country'];
					$this->name = $team['name'];
					$this->active = $team['active'];
					$this->shortName = $team['shortName'];
					$this->images = $this->setImages($team['images']);
					$this->manager = $team['manager'];
					$this->dob = $team['dob'];
					break;
				}
			}

		}
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

	protected function setImages(array $images) : array {
		$imagesArr = [];
		foreach($images as $image) {
			$imagesArr[] = new Image($image);
		}
		return $imagesArr;
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

