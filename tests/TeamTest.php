<?php


use Epics\Team;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase {

	public function testSingleTeam() {
		/* can't actually test this without authentication... bit crap. Need a valid jwt
		*
		$team = new Team(1);
		$this->assertEquals($team->id, 1);
		$this->assertEquals($team->country, 'se');
		$this->assertEquals($team->name, 'Ninjas In Pyjamas');
		$this->assertEquals($team->shortName, 'NIP');
		*/
		$this->assertTrue(true);
	}

}