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


	public function __construct(array $args) {
		parent::__construct($args);

		$this->age = $args['age'];
		$this->dob = $args['dob'];
		$this->country = $args['country'];
		$this->gameId = $args['gameId'];
		$this->handle = $args['handle'];
		$this->position = $args['position'];
		$this->frameType = $args['frameType'];
		$this->lastDate = $args['lastDate'];
		$this->active = $args['active'];
		$this->videos = $this->setVideos($args['videos']);
		$this->playerFrames = $this->setPlayerFrames($args['playerFrames']);
					
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