<?php
declare(strict_types = 1);

namespace Epics\Entity;
use Epics\Item\CardTemplateList;
use Epics\Cache;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\Cache\ItemInterface;

class Collection extends Entity {

	protected static $endpoint = EPICS__API_ENDPOINT . 'collections';

	protected $categoryId;
	protected $visible;
	protected $properties;
	protected $beta = null;
	protected $groupTreatments;
	protected $created;
	protected $updated;



	public function __construct(array $args) {
		parent::__construct($args);

		$this->visible = $args['visible'];
		$this->beta = $args['beta'];
		$this->groupTreatments = $args['groupTreatments'];
		$this->created = $args['created'];
		$this->updated = $args['updated'];
		$this->properties = $args['properties'];
		$this->categoryId = $args['categoryId'];

		return $this;
	}

	public function getCardTemplates($setTreatment = true) {
		return new CardTemplateList($this->id, $setTreatment);
	}


}