<?php 

namespace Epics\Item;
use Epics\Image;

class Item {

	public $id;
	public $uuid;

	public function __construct(array $args) {
		$this->id = $args['id'];
		$this->uuid = $args['uuid'];
	}


}

