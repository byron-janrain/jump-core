<?php
namespace janrain\jump;

use \PHPUnit_Framework_TestCase;

class UserTest extends PHPUnit_Framework_TestCase
{
	public function testCreate() {
		User::create(array());
	}

	public function testCreatedUuidSuccess() {
		$u = User::create(array());
		$this->assertInternalType('string', $u->getUuid());
		$this->assertEquals(37, strlen($u->getUuid()));
	}

	public function testCreateFromCaptureData() {
		$u = User::__set_state(array('uuid' => `uuidgen`));
		$this->assertInternalType('string', $u->getUuid());
		$this->assertEquals(37, strlen($u->getUuid()));
	}
}
