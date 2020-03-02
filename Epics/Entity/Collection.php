<?php
declare(strict_types = 1);

namespace Epics\Entity;

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
		parent::__construct($args);
		$this->visible = $args['visible'];
		$this->beta = $args['beta'];
		$this->groupTreatments = $args['groupTreatments'];
		$this->created = $args['created'];
		$this->updated = $args['updated'];
		$this->properties = $args['properties'];
		return $this;
	}


}