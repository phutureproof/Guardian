<?php
/**
 * Created by PhpStorm.
 * User: Dale
 * Date: 12/04/2016
 * Time: 18:29
 */

namespace PhutureProof\Guardian\Tests;

use PhutureProof\Guardian;

class MockObject
{
	/** @var string $name */
	protected $name;

	public function __construct()
	{
		$this->name = 'MockObject';
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

}

class GaurdianTest extends \PHPUnit_Framework_TestCase
{
	private $subject;
	
	public function __construct()
	{
		parent::__construct();
		$this->subject = new Guardian();
	}
	
	public function testGuardianConstructor()
	{

		$this->assertEquals(true, true);
	}
}
