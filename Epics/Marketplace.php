<?php
declare(strict_types = 1);

namespace Epics;
use Symfony\Component\HttpClient\HttpClient;

class Marketplace {

	protected static $endpointBuy = EPICS__API_ENDPOINT . 'buy';
	protected static $endpointList = EPICS__API_ENDPOINT . 'list';

	public static function list(int $cardId, int $price, $minOffer = null, string $type = 'card') {
		$client = HttpClient::create();
		$headers = EPICS__HTTP_HEADERS;
		$cache = new Cache();
		$headers['X-User-JWT'] = $cache->get('jwt');

		$response = $client->request('POST', self::$endpointList . '?categoryId=1', [ 
						'headers' => $headers,
						'json' => [
							'id' => $cardId,
							'price' => $price,
							'minOffer' => $minOffer,
							'type' => $type
						]
					]);

		if($response->getStatusCode() == 200) {
			$decodedPayload = $response->toArray();	
			if($decodedPayload['success']) {
				return new MarketListing($decodedPayload['data']['marketId']);
			}
		}

		return false;
	}


	public static function buy(int $listingId, int $price) : bool {
		$client = HttpClient::create();
		$headers = EPICS__HTTP_HEADERS;
		$cache = new Cache();
		$headers['X-User-JWT'] = $cache->get('jwt');

		$response = $client->request('POST', self::$endpointBuy . '?categoryId=1', [ 
						'headers' => $headers,
						'json' => [
							'marketId' => $listingId,
							'price' => $price
						]
					]);

		if($response->getStatusCode() == 200) {
			$decodedPayload = $response->toArray();	
			if($decodedPayload['success']) {
				return true;
			}
		}

		return false;

	}



}