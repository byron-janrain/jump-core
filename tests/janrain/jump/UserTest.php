<?php
namespace janrain\jump;

class UserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testCreate($data)
    {
        $jumper = User::create($data);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testSetStateNoUuid()
    {
        $jumper = User::__set_state([]);
    }

    /**
    * @dataProvider getData
    */
    public function testSetState($data)
    {
        $jumper = User::__set_state($data);
        $this->assertInstanceOf(User::class, $jumper);
    }

    /**
    * @dataProvider getData
    */
    public function testGetAttributePaths($data, $paths)
    {
        $jumper = User::__set_state($data);
        var_dump($jumper);
        $this->assertEquals($paths, $jumper->getAttributePaths());
    }

    /**
     * @dataProvider getData
     */
    public function testSetAttribute($data)
    {
        $jumper = User::__set_state($data);
        $jumper->setAttribute('/name/first', 'TesterToo');
        $this->assertEquals('TesterToo', $jumper->getAttribute('/name/first'));
        $jumper->setAttribute('/bob', 'bob');
        $this->assertEquals(null, $jumper->getAttribute('/bob'));
    }

    /**
     * @dataProvider getData
     */
    public function testGetAttribute($data)
    {
        $jumper = User::__set_state($data);
        $firstname = $jumper->getAttribute('/name/first');
        $this->assertEquals('Tester', $firstname);
        $this->assertEquals(null, $jumper->getAttribute('/thereisnospoon'));
        $this->assertEquals(null, $jumper->getAttribute('thereisnospoon'));
    }

    /**
     * @dataProvider getData
     */
    public function testHasAttribute($data)
    {
        $jumper = User::__set_state($data);
        $this->assertEquals(true, $jumper->hasAttribute('/uuid'));
        $this->assertEquals(false, $jumper->hasAttribute('uuid'));
    }

    public function getData()
    {
        $testJson = '{"name":{"first":"Tester","last":"Testerton"},"uuid":12345,"somes":["stuff1","stuff2","stuff3"]}';
        $obj = json_decode($testJson, true);
        return [
            [$obj, ['/name','/name/first', '/name/last', '/uuid','/somes','/somes#1','/somes#2', '/somes#3']],
            ];
    }
}
