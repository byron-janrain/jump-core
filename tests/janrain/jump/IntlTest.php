<?php
namespace janrain\jump;

class IntlTest extends \PHPUnit_Framework_TestCase
{

	public function testFactoryInit()
	{
		$xlate = Intl::createForLang();
		$this->assertInstanceOf($xlate, 'janrain\\jump\\Intl');
	}

	public function testInitDefaultsToEnUs()
	{
		$xlate = Intl::createForLang();
		$rc = new \ReflectionClass($xlate);
		$p = $rc->getProperty('lang');
		$p->setAccessible(true);
		$this->assertEquals('en_us', $p->getValue($xlate));
	}

	public function testInitLangSet()
	{
		$xlate = Intl::createForLang('fr-ca');
		$rc = new \ReflectionClass($xlate);
		$p = $rc->getProperty('lang');
		$p->setAccessible(true);
		$this->assertEquals('fr-ca', $p->getValue($xlate));
	}

	public function testTranslate()
	{
		$xlate = Intl::createForLang();
		$translated = $xlate("There is no spoon!");
		$this->assertEquals("There is no spoon!", $translated);
	}
}
