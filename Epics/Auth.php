<?php 

namespace Epics;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Component\ErrorHandler\ErrorHandler;

class Auth {

	protected static $endpoint = EPICS__API_ENDPOINT . 'auth/login?categoryId=1&gameId=1';
	
	public $jwt;

	protected $user;	
	protected $loggedIn;
	protected $expires;

	public function __construct($username = '', $password = '') {
		$this->loggedIn = true;
		$cache = new FilesystemAdapter('epics', 0, './cache/');
		$jwt = $cache->getItem('jwt');

		if(!$jwt->isHit()) {
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
					$cache->save($jwt);
				} else {
					throw new \RuntimeException('[Epics] Authentication failed. Check credentials.');
				}
			} else {
				throw new \RuntimeException('[HTTP '.$response->getStatusCode().'] Error obtaining response from: ' . self::$endpoint);
			}
		}

		$this->jwt = $jwt->get();

	}

	public function clearJWT() {
		$cache = new FilesystemAdapter();
		$cache->deleteItem('jwt');
	}


}