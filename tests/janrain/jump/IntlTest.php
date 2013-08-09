<?php
namespace janrain\jump;

class IntlTest extends \PHPUnit_Framework_TestCase
{

    public function testFactoryInit()
    {
        $xlate = Intl::createForLang();
        $this->assertInstanceOf(__NAMESPACE__ . '\\' . 'Intl', $xlate);
    }

    public function testInitDefaultsToEnUs()
    {
        $xlate = Intl::createForLang();
        $this->assertAttributeEquals('en_us', 'lang', $xlate);
    }

    public function testInitLangSet()
    {
        $xlate = Intl::createForLang('fr-ca');
        $this->assertAttributeEquals('fr-ca', 'lang', $xlate);
    }

    public function testTranslateNoSubs()
    {
        $xlate = Intl::createForLang();
        $translated = $xlate("There is no spoon!");
        $this->assertEquals("There is no spoon!", $translated);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testTranslateNonString()
    {
        $xlate = Intl::createForLang();
        $translated = $xlate(array());
    }

    public function testTranslatePreprocessor()
    {
        $xlate = Intl::createForLang();
        $translated = $xlate('String!', function ($string) { return substr($string, 0, -1);});
        $this->assertEquals('String', $translated);
    }
}
