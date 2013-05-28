<?php
namespace janrain\jump;

use \PHPUnit_Framework_TestCase;

use \ArrayAccess;
use \ArrayObject;

class ApiTest extends PHPUnit_Framework_TestCase
{

	protected $config;

	public function setUp() {
		$this->config = new ArrayObject(json_decode(file_get_contents('/Users/byron/captureinfo.json'), true));
	}

	public function testInit()
	{
		$api = new Api($this->config);
		$this->assertInstanceof('\janrain\jump\Api', $api);
	}

	/**
	 * @depends testInit
	 */
	public function testApi()
	{
		$api = new Api($this->config);
		$answer = $api('entity.count', array('type_name' => 'user'));
		$this->assertEquals('ok', $answer->stat);
	}

	public function testFetchUserByUuid()
	{
		$api = new Api($this->config);
		$answer = $api('entity', array('type_name' => 'user', 'uuid' => '19e572b5-ba23-42b1-afcb-23b7d9d91fef'));
		var_dump($answer);
	}

	public function configProvider()
	{
	}
}
