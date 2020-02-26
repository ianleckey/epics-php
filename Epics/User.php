<?php
namespace Epics;
class User {


	protected $id;
	protected $firstName;
	protected $lastName;
	protected $userName;
	/*protected $email;
	protected $balance;*/


	public function __construct(int $id) {
		$this->id = $id;
	}


}