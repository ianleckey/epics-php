<?php


use Epics\Entity\TeamList;
use Epics\Entity\Team;
use PHPUnit\Framework\TestCase;

class TeamTest extends TestCase {

	public $teams;

	public function setUp(): void {
		parent::setUp();
		$this->teams = new TeamList(false);
		$this->teams->add(
				array(
					'id' => 1,
					'shortName' => 'NIP',
					'manager' => 'N/A',
					'name' => 'Ninjas In Pyjamas',
					'active' => true,
					'country' => 'se',
					'dob' => '2000-06-01',
					'images' => array()
				)
			);
		$this->teams->add(
				array(
					'id' => 132,
					'shortName' => 'VTL',
					'manager' => 'N/A',
					'name' => 'Vitality',
					'active' => true,
					'country' => 'fr',
					'dob' => '2019-10-28',
					'images' => array()
				)
			);
	}

	public function testTeamList() {
		$this->assertEquals( $this->teams->count(), 2 );
		$this->assertEquals( $this->teams->order('id','desc')->result()[0]->id, 132);
		$this->assertEquals( $this->teams->filter('country','se')->count(), 1 );
		$this->assertEquals( $this->teams->filter('country','fr')->count(), 0 );
		$this->assertEquals( $this->teams->filter('shortName','VTL')->count(), 0 );
	}

}