<?php 
namespace Epics;
use Symfony\Component\HttpClient\HttpClient;

class Team {
	
	protected $endpoint = EPICS__API_ENDPOINT . 'teams';

	protected $id;
	protected $country;
	protected $name;
	protected $gameId;
	protected $active;
	protected $images;
	protected $playerIds;

	public function __construct(int $id) {
		global $auth;
		$client = HttpClient::create();
		$headers = EPICS__HTTP_HEADERS;
		$headers['X-User-JWT'] = $auth->jwt;

		$response = $client->request('GET', $this->endpoint, [
								'headers' => $headers,
								'query' => [
									'categoryId' => 1
								]
							]);
		
		if($response->getStatusCode() == 200) {

		}

	}

	private function setCardTemplate($cardTemplate) {
		$this->cardTemplate = new CardTemplate($cardTemplate->id);
	}

	private function setImages($images) {
		foreach($images as $image) {
			/*$this->images = new Image($image->id);*/
		}
	}
}

