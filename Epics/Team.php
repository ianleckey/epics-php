<?php 
namespace Epics;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;


class Team {
	
	protected static $endpoint = EPICS__API_ENDPOINT . 'teams';

	protected $id;
	protected $country;
	protected $name;
	protected $active;
	protected $images;
	protected $shortName;
	protected $manager;
	protected $dob;
	protected $playerIds;

	public function __construct(int $id = 0) {
		if($id > 0) {
			if(EPICS__CACHING) {
				$cache = new FilesystemAdapter('epics', 0, './cache/');
				$teams = $cache->getItem('teams');
				if(!$teams->isHit()) {
					$teams->expiresAfter(EPICS__CACHE_EXPIRES);
					$teams->set($this->getAllTeams());
					$cache->save($teams);
				}
				
				$allTeams = $teams->get();
			} else {
				$allTeams = $this->getAllTeams();
			}

			foreach($allTeams as $team) {
				if($team['id'] === $id) {
					$this->id = $id;
					$this->country = $team['country'];
					$this->name = $team['name'];
					$this->active = $team['active'];
					$this->shortName = $team['shortName'];
					$this->images = $team['images'];
					$this->manager = $team['manager'];
					$this->dob = $team['dob'];
					break;
				}
			}
		}
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

