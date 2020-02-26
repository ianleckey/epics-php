<?php


use Epics\Auth;
use PHPUnit\Framework\TestCase;

class AuthTest extends Epics\Auth {

	public function setUp() {
		parent::setUp();
	}

	public function testAuthFail() {
		$auth = new Auth('somerandomemail@email.com', 'somerandompassword'); 
		$this->assertFalse($auth->loggedIn);
	}

}