<?php 

namespace Epics\Entity;
use Epics\Image;
class Entity {

	public $id;
	public $name;
	protected $images;


	public function __construct(array $args) {
		$this->id = $args['id'];
		$this->name = $args['name'];
		$this->images = $this->setImages($args['images']);
	}

	protected function setImages(array $images) : array {
		$imagesArr = [];
		foreach($images as $image) {
			$imagesArr[] = new Image($image);
		}
		return $imagesArr;
	}

	protected function setVideos(array $videos) : array {
		$videosArr = [];
		foreach($videos as $video) {
			$videosArr[] = new Video($video);
		}
		return $videosArr;
	}
	
}

