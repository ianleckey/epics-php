<?php


use Epics\Auth;
use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase {

	public function testAuthFail() {
		$auth = new Auth('somerandomemail@email.com', 'somerandompassword', true); 
		$this->assertFalse($auth->loggedIn);
	}

}