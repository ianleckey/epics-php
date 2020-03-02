<?php
declare(strict_types = 1);

namespace Epics;
use Symfony\Component\OptionsResolver\OptionsResolver;


class Image {
	
	protected $id;
	protected $parentType;
	protected $parentId;
	public $name;
	protected $position;
	public $url;
	public $cardSide;
	protected $treatmentId;
	protected $properties;

	protected static $cdnUrl = 'https://cdn.epics.gg';


	/**
	* @param array $properties (id|parentType|parentId|name|position|url|cardSide|treatmentId|properties)
	* @return Image
	* 
	**/
	public function __construct(array $properties = []) {
       foreach ($this->getOptions()->resolve($properties) as $property => $value) {
       		if($property === 'id') {
       			$this->setId($value);
       		} else if($property === 'url') {
       			$this->setUrl($value);
       		} else if($property === 'parent_type') {
				$this->parentType = $value;
       		} else {
            	$this->{$property} = $value;
            }
        }
	}

	public function getOptions(): OptionsResolver {
		$resolver = new OptionsResolver();
		$resolver->setRequired([
			'id',
			'parentType',
			'parent_type',
			'parentId',
			'name',
			'position',
			'url',
			'cardSide',
			'treatmentId',
			'properties'
		]);
		$resolver->setAllowedTypes('id', ['int','string']);
		$resolver->setAllowedTypes('parentType', 'string');
		$resolver->setAllowedTypes('parent_type', 'string');
		$resolver->setAllowedTypes('parentId', 'int');
		$resolver->setAllowedTypes('name', 'string');
		$resolver->setAllowedTypes('position', 'string');
		$resolver->setAllowedTypes('url', 'string');
		$resolver->setAllowedTypes('cardSide', 'string');
		$resolver->setAllowedTypes('treatmentId', ['int','null']);
		$resolver->setAllowedTypes('properties', ['array','null']);

		$resolver->setDefault('parent_type', '');
		$resolver->setDefault('parentType', '');
		
		return $resolver;
	}

	private function setId($id) : int {
		$this->id = (int)$id; 
		return $this->id;
	}

	private function setUrl(string $url) : string {
		$this->url = self::$cdnUrl . $url;
		return $this->url;
	}

}