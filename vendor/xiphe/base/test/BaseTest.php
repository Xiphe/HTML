<?php

use Xiphe\Base;

require_once 'PHPUnit/Framework/TestCase.php';
require_once '../src/Xiphe/Base.php';

 
class ArrayTest extends PHPUnit_Framework_TestCase {
	
	function testClassExists()
	{
		$this->assertTrue(class_exists('\Xiphe\Base'));
	}

	function testClassCanBeInstantiated()
	{
		$this->assertEquals("Xiphe\Base", get_class(Base::i()));
		$this->assertTrue(Base::i() == new Base());
	}

	function testInitFallbackExists()
	{
		$this->assertEquals(null, Base::i()->init());
	}
}