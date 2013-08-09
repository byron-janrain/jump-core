<?php
namespace janrain\jump;

class FeatureStackTest extends \PHPUnit_Framework_TestCase
{
    protected $mockFeature;

    public function setUp()
    {
        $this->mockFeatureName = 'MockFeature';
        $this->mockFeature = $this->getMockBuilder(__NAMESPACE__ . '\\AbstractFeature')
            ->disableOriginalConstructor()
            ->getMock();
        $this->mockFeature->expects($this->any())
            ->method('getName')
            ->will($this->returnValue($this->mockFeatureName));
        $this->mockFeature->expects($this->any())
            ->method('getPriority')
            ->will($this->returnValue(1));
    }

    public function testInit()
    {
        $stack = new FeatureStack();
        $this->assertCount(0, $stack);
    }

    public function testPushFeature()
    {
        $stack = new FeatureStack();
        $stack->pushFeature($this->mockFeature);
        $this->assertEquals(1, $stack->count());
        $features = iterator_to_array($stack);
        $this->assertContains($this->mockFeature, $features);
    }

    public function testGetFeatureByName()
    {
        $stack = new FeatureStack();
        $stack->pushFeature($this->mockFeature);
        $getFeature = $stack->getFeature($this->mockFeature->getName());
        $this->assertSame($this->mockFeature, $getFeature);
    }

    public function testFeaturesGetPrioritized()
    {
        $stack = new FeatureStack();
        $secondFeature = $this->getMockBuilder(__NAMESPACE__ . '\\AbstractFeature')
            ->disableOriginalConstructor()
            ->getMock();
        $secondFeature->expects($this->any())
            ->method('getName')
            ->will($this->returnValue('Feature2'));
        $secondFeature->expects($this->any())
            ->method('getPriority')
            ->will($this->returnValue(2));
        $stack->pushFeature($secondFeature);
        $stack->pushFeature($this->mockFeature);
        $features = iterator_to_array($stack);
        $this->assertSame(array_shift($features), $this->mockFeature);
    }

    /**
     * @dataProvider badNameProvider
     */
    public function testGetNonFeatureByName($badName)
    {
        $stack = new FeatureStack();
        $stack->pushFeature($this->mockFeature);
        $this->assertEquals(null, $stack->getFeature($badName));
    }

    public function badNameProvider()
    {
        return array(
            array('NO SUCH FEATURE'),
            array(''),
            array(null)
        );
    }
}
