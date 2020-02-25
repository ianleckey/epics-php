<?php

const EPICS__API_ENDPOINT = 'https://api.epics.gg/api/v1/auth/';

const EPICS__HTTP_REFERER = 'https://app.epics.gg';

const EPICS__HTTP_HEADERS = [
								'Accept' => '*/*',
								'Accept-Language' => 'en-GB,en;q=0.7,en;q=0.3',
								'Referer' => EPICS__HTTP_REFERER.'/',
								'Content-Type' => 'application/json',
								'X-User-JWT' => '',
								'Origin' => EPICS__HTTP_REFERER,
								'DNT' => '1',
								'Connection' => 'keep-alive',
								'TE' => 'Trailers',
								'Pragma' => 'no-cache',
								'Cache-Control' => 'no-cache'
							];

?>