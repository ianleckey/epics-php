<?php 
declare(strict_types = 1);
namespace Epics\Entity;
use Epics\Image;
class Entity {

	public $id;
	public $name;
	protected $images;


	public function __construct(array $args = array()) {
		$this->id = $args['id'] ?? 0;
		$this->name = $args['name'] ?? '';
		if(array_key_exists('images', $args)) {
			$this->images = $this->setImages($args['images']);	
		} else {
			$this->images = array();
		}
		
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

