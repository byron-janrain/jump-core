<?php
namespace janrain\jump;

use \ArrayObject;

class CaptureApiTest extends \PHPUnit_Framework_TestCase
{
    protected $config;

    public function setUp() {
        $fileConfig = new \ArrayObject(json_decode(file_get_contents('/Users/byron/captureinfo.json'), true));
        $this->config = new CaptureApiConfig($fileConfig);
    }

    public function testInit()
    {
        $api = new CaptureApi($this->config);
        $this->assertInstanceof(CaptureApi::class, $api);
    }

    /**
     * @depends testInit
     */
    public function testApi()
    {
        $api = new CaptureApi($this->config);
        $answer = $api('entity.count', ['type_name' => 'user']);
        $this->assertEquals('ok', $answer['stat']);
    }

    public function testFetchUserByUuid()
    {
        $api = new CaptureApi($this->config);
        $answer = $api->fetchUserByUuid('e2c9174b-0904-4757-a15a-f3d8d149983a');
        $this->assertInstanceof(\janrain\jump\User::class, $answer);
    }

    public function testGenerateUuid()
    {
        $uuid = CaptureApi::generateUuid();
        $this->assertInternalType('string', $uuid);
    }

    public function testGetToken()
    {
        $api = new CaptureApi($this->config);
        $token = $api->getToken('e2c9174b-0904-4757-a15a-f3d8d149983a');
        $this->assertObjectHasAttribute('token', $token);
        $this->assertObjectHasAttribute('expires', $token);
    }
}
