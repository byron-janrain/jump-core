<?php
namespace janrain\jump;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateNew()
    {
        $user = User::create();
        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testCreateNoData()
    {
        $user = User::__set_state();
    }

    /**
     * @expectedException Exception
     */
    public function testCreateFailsWithoutUuid()
    {
        $user = User::__set_state(['name' => 'Murphy']);
    }

    public function testGetId()
    {
        $uuid = strtolower(`uuidgen`);
        $u = User::__set_state(['uuid' => $uuid]);
        $this->assertEquals($uuid, $u->getId());
    }

    /**
     * @dataProvider generateGoodData
     */
    public function testGetProperty($data)
    {
        $user = User::__set_state($data);
        $this->assertEquals($data['uuid'], $user->uuid);
        $this->assertEquals($data['uuid'], $user['uuid']);
    }

    /**
     * @dataProvider generateGoodData
     */
    public function testGetMissingPropertyReturnsNull($data)
    {
        $user = User::__set_state($data);
        $this->assertNull($user['thereisnospoon']);
        $this->assertNull($user['/thereisnospoon']);
    }

    /**
     * @dataProvider generateGoodData
     */
    public function testGetNestedProperty($data)
    {
        $user = User::__set_state($data);
        $this->assertEquals($data['plural'][0]['index'], $user['/plural#1/index']);
    }

    /**
     * @dataProvider generateGoodData
     */
    public function testGetMissingNestedPropertyReturnsNull($data)
    {
        $user = User::__set_state($data);
        $this->assertNull($user['/plural#3']);
    }

    /**
     * @dataProvider generateGoodData
     */
    public function testSetNestedProperty($data)
    {
        $user = User::__set_state($data);
        $user['/plural#2/index'] = 5;
        $this->assertEquals(5, $user->plural[1]['index']);
    }

    /**
     * @dataProvider generateGoodData
     */
    public function testOffsetUnsetDoesNothing($data)
    {
        $user = User::__set_state($data);
        unset($user['/plural#2/index']);
        $this->assertEquals(2, $user['/plural#2/index']);
    }

    /**
     * @dataProvider generateGoodData
     */
    public function testGetMappableFields($data)
    {
        $user = User::__set_state($data);
        $this->assertEquals(array_keys($data), $user->getMappableFields());
    }

    /**
     * @dataProvider generateGoodData
     * @expectedException InvalidArgumentException
     */
    public function testSetNestedPropertyBadPath($data)
    {
        $user = User::__set_state($data);
        $user['/thereisnospoon'] = 'value';
    }

    public function generateGoodData()
    {
        return [
            [
                [
                    'uuid' => strtolower(`uuidgen`),
                    'email' => 'jumper@janrain.com',
                    'nested' => ['property' => 'value'],
                    'plural' => [
                        ['index' => 1],
                        ['index' => 2],
                    ],
                ]
            ],
        ];
    }
}
