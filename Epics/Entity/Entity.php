<?php 

namespace Epics\Entity;

abstract class Entity {

	public $id;
	public $name;
	protected $images;
	public $active;
	public $country;
	public $dob;

	abstract protected function setImages(array $images);

}

