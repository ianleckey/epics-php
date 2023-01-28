<?php 

namespace Epics;
use Epics\Cache;
use Epics\User;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\ErrorHandler\ErrorHandler;

class Auth {

	protected static $endpoint = EPICS__API_ENDPOINT . 'auth/login?categoryId=1&gameId=1';
	
	public bool $loggedIn;

	protected User $user;	
	protected $expires;

	public function __construct(string $username = '', string $password = '', bool $forceNewJwt = false) {
		$this->loggedIn = true;
		
		$cache = new Cache();
		$jwt = $cache->pool->getItem('jwt');

		if(!$jwt->isHit() || $forceNewJwt) {
			$this->loggedIn = false;
			$client = HttpClient::create();
			$response = $client->request('POST', self::$endpoint, [
								'json' => [
									'email' => (string)$username,
									'password' => (string)$password
								]
							]);
			
			if($response->getStatusCode() == 200) {
				$decodedPayload = $response->toArray();	
				if($decodedPayload['success']) {
					$this->loggedIn = true;
					$this->user = new User((int)$decodedPayload['data']['user']['id']);
					$this->expires = $decodedPayload['data']['expires'];
					$jwt->expiresAfter($decodedPayload['data']['expires'] - time());
					$jwt->set($decodedPayload['data']['jwt']);
					$cache->pool->save($jwt);
				}
			}
		}

	}

}
