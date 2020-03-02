<?php

namespace Epics\Entity;
use Epics\Image;
use Epics\Cache;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\Cache\ItemInterface;
use Epics\Entity\Collection;


class Collection extends Entity {

	protected static $endpoint = EPICS__API_ENDPOINT . 'collections';

	/*protected $id;
	protected $name;*/
	protected $categoryId;
	protected $visible;
	protected $properties;
	protected $beta = null;
	protected $groupTreatments;
	protected $created;
	protected $updated;

	public function __construct(array $args) {
		$this->id = $args['id'];
		$this->name = $args['name'];
		$this->visible = $args['visible'];
		$this->beta = $args['beta'];
		$this->images = $this->setImages($args['images']);
		$this->groupTreatments = $args['groupTreatments'];
		$this->created = $args['created'];
		$this->updated = $args['updated'];
		$this->properties = $args['properties'];
		return $this;
	}

	protected function setImages(array $images) : array {
		$imagesArr = [];
		foreach($images as $image) {
			$imagesArr[] = new Image($image);
		}
		return $imagesArr;
	}
}