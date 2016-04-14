<?php
/**
 * Guardian tests
 * Dale Paget <dale@phutureproof.com>
 */

namespace PhutureProof\Guardian\Tests;

use PhutureProof\Guardian;

class MockObject
{
    /** @var string $name */
    protected $name;

    /**
     * MockObject constructor.
     * @param string $name
     */
    public function __construct($name = 'MockObject')
    {
        $this->name = $name;
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

class MockObjectTwo extends MockObject
{
    protected $name;

    public function __construct()
    {
        parent::__construct();
        $this->setName('MockObjectTwo');
    }
}

class GuardianTest extends \PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function testGuardianConstructor()
    {
        $this->assertTrue(is_array(Guardian::getDependencies()));
    }

    public function testGuardianRegister()
    {
        Guardian::register('mock.object', function () {
            return new MockObject();
        });
        $this->assertArrayHasKey('mock.object', Guardian::getDependencies());
    }

    public function testGuardianReturnsCorrectObjectType()
    {
        Guardian::register('mock.object', function () {
            return new MockObject();
        });
        $this->assertTrue(Guardian::make('mock.object') instanceof MockObject);
        Guardian::register('mock.object.two', function () {
            return new MockObjectTwo();
        });
        $this->assertTrue(Guardian::make('mock.object.two') instanceof MockObjectTwo);
    }

    public function testGuardianReturnedObjectsContainCorrectMethods()
    {
        Guardian::register('mock.object', function () {
            return new MockObject();
        });

        Guardian::register('mock.object.two', function () {
            return new MockObjectTwo();
        });

        /** @var MockObject $mockObject */
        $mockObject = Guardian::make('mock.object');

        /** @var MockObjectTwo $mockObjectTwo */
        $mockObjectTwo = Guardian::make('mock.object.two');

        $this->assertEquals('MockObject', $mockObject->getName());
        $this->assertEquals('MockObjectTwo', $mockObjectTwo->getName());
    }


    public function testGuardianReturnedObjectConstructorAcceptedArgument()
    {
        $name = 'NewName';

        Guardian::register('mock.object', function () use ($name) {
            return new MockObject($name);
        });

        /** @var MockObject $mockObject */
        $mockObject = Guardian::make('mock.object', $name);

        $this->assertEquals($name, $mockObject->getName());
    }

    public function testGuardianStaticResolverIsStatic()
    {
        $static = 'singleton.dependency.name';
        $shared = 'shared.dependency.name';

        Guardian::register($static, function () {
            static $instance;
            if (is_null($instance)) {
                $instance = new MockObject();
            }
            return $instance;
        });

        Guardian::register($shared, function () {
            return new MockObjectTwo();
        });

        $this->assertFalse((Guardian::make($shared) === Guardian::make($shared)));
        $this->assertTrue((Guardian::make($static) === Guardian::make($static)));
    }

    public function testGuardianThrowsExceptionForBadResolver()
    {
        $this->expectException('PhutureProof\\Guardian\\Exceptions\\ResolverMissingException');

        Guardian::make('thisshouldthrowanexception');
    }
}
