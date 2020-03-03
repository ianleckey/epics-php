<?php
declare(strict_types = 1);

namespace Epics;
use Symfony\Component\HttpClient\HttpClient;

class Marketplace {

	protected static $endpointBuy = EPICS__API_ENDPOINT . 'buy';
	protected static $endpointList = EPICS__API_ENDPOINT . 'list';

	/*
	{id: 73783915, price: "1", minOffer: null, type: "card"}
	id: 73783915
	price: "1"
	minOffer: null
	type: "card"

	{"success":true,"data":{"marketId":2348340}}
	*/
	public static function list(int $cardId, int $price, $minOffer = null, string $type = 'card') {
		$client = HttpClient::create();
		$headers = EPICS__HTTP_HEADERS;
		$cache = new Cache();
		$headers['X-User-JWT'] = $cache->get('jwt');
		/* POST
		$response = $client->request('GET', self::$endpointList, [ 
						'headers' => $headers,
						'query' => [
							'categoryId' => 1
						]
					]);
		*/
		if($response->getStatusCode() == 200) {
			$decodedPayload = $response->toArray();	
			if($decodedPayload['success']) {
				return new MarketListing($decodedPayload['data']['marketId']);
			}
		}

		return false;
	}

	/*
	{marketId: 2323550, price: 1}
	marketId: 2323550
	price: 1

	{"success":true}
	*/
	public static function buy(int $cardId) {

	}



}