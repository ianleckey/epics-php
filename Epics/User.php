<?php
namespace Epics;
class User {


	protected int $id;
	protected string $firstName;
	protected string $lastName;
	protected string $userName;
	/*protected $email;
	protected $balance;*/


	public function __construct(int $id) {
		$this->id = $id;
	}


}
