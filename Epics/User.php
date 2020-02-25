<?php

class User {


	protected $id;
	protected $firstName;
	protected $lastName;
	protected $userName;
	/*protected $email;
	protected $balance;*/


	public function __construct(int $id) {

		//$client = HttpClient::create();
		/*$response = $client->request('POST', EPICS__API_ENDPOINT . $this->loginPath, [
							'headers' => EPICS__HTTP_HEADERS,
							'json' => [
								'email' => $username,
								'password' => $password
							]
						]);

		if($response->getStatusCode() == 200) {
			$decodedPayload = $response->toArray();	
			if($decodedPayload['success']) {
				$this->jwt = $decodedPayload['data']['jwt'];
				$this->userId = $decodedPayload['data']['user']['id'];
			}
		}*/


	}


}