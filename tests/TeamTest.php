<?php


use Epics\Team;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase {

	public function testSingleTeam() {
		$team = new Team(1);
		$this->assertEquals($team->id, 1);
		$this->assertEquals($team->country, 'se');
		$this->assertEquals($team->name, 'Ninjas In Pyjamas');
		$this->assertEquals($team->shortName, 'NIP');
	}

}