<?php 
namespace Epics;
use Epics\Image;
use Epics\Cache;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\Cache\ItemInterface;


class Team {
	
	protected static $endpoint = EPICS__API_ENDPOINT . 'teams';

	public $id;
	public $country;
	public $name;
	public $active;
	protected $images;
	public $shortName;
	public $manager;
	public $dob;
	protected $playerIds;

	public function __construct(int $id = 0) {
		if($id > 0) {

			$cache = new Cache();
			$teams = $cache->pool->getItem('teams');
			if(!$teams->isHit()) {
				$teams->expiresAfter(Cache::$expires);
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

	private function setImages($images) {
		$imagesArr = [];
		foreach($images as $image) {
			$imagesArr[] = new Image($image);
		}
		return $imagesArr;
	}

	public static function getAllTeams() {
		
		$client = HttpClient::create();
		$headers = EPICS__HTTP_HEADERS;
		$cache = new FilesystemAdapter('epics', 0, './cache/');
		$headers['X-User-JWT'] = $cache->getItem('jwt')->get();
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

