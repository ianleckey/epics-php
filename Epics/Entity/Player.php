<?php

namespace Epics\Entity;
use Epics\Image;
use Epics\Cache;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\Cache\ItemInterface;

class Player extends Entity {
	
	protected static $endpoint = EPICS__API_ENDPOINT . 'players';

	protected $active;
	protected $country;
	protected $dob;
	protected $age;
	protected $gameId;
	protected $handle;
	protected $position;
	protected $frameType;
	protected $lastDate;
	protected $videos;
	protected $playerFrames;
	protected $teamId;


	public function __construct(int $id = 0) {
		if($id > 0) {

			$cache = new Cache();
			$players = $cache->pool->getItem('players');
			if(!$players->isHit()) {
				$players->set($this->getAllPlayers());
				
				$cache->pool->save($players);

			}
			
			$allPlayers = $players->get();

			foreach($allPlayers as $player) {
				if($player['id'] === $id) {
					$this->id = $id;
					$this->name = $player['name'];
					$this->age = $player['age'];
					$this->dob = $player['dob'];
					$this->country = $player['country'];
					$this->gameId = $player['gameId'];
					$this->handle = $player['handle'];
					$this->position = $player['position'];
					$this->frameType = $player['frameType'];
					$this->lastDate = $player['lastDate'];
					$this->active = $player['active'];
					$this->images = $this->setImages($player['images']);
					$this->videos = $this->setVideos($player['videos']);
					$this->playerFrames = $this->setPlayerFrames($player['playerFrames']);
					
					break;
				}
			}

		}
	}

	protected function setImages(array $images) : array {
		$imagesArr = [];
		foreach($images as $image) {
			$imagesArr[] = new Image($image);
		}
		return $imagesArr;
	}

	protected function setVideos(array $videos) : array {
		$videosArr = [];
		foreach($videos as $video) {
			$videosArr[] = new Video($video);
		}
		return $videosArr;
	}

	protected function setPlayerFrames(array $playerFrames) : array {
		/*$playerFramesArr = [];
		foreach($playerFrames as $playerFrame) {
			$playerFramesArr[] = new PlayerFrame($playerFrame);
		}
		return $playerFramesArr;*/
		return $playerFrames;
	}

	public static function getAllPlayers() : array {
		
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
			return $decodedPayload['data']['players'];
		}

	}	

}