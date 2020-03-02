<?php 

namespace Epics\Entity;

abstract class Entity {

	public $id;
	public $name;
	protected $images;

	abstract protected function setImages(array $images): array;

}

