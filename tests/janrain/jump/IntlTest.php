<?php
namespace janrain\jump;

class IntlTest extends \PHPUnit_Framework_TestCase
{

	public function testFactoryInit()
	{
		$xlate = Intl::createForLang();
		$this->assertInstanceOf(Intl::class, $xlate);
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

	public function testTranslate()
	{
		$xlate = Intl::createForLang();
		$translated = $xlate("There is no spoon!");
		$this->assertEquals("There is no spoon!", $translated);
	}
}
