<?php

namespace Pepper\Tests\ClassFinder;

use Pepper\ClassFinder\ClassFinder;

class ClassFinderTest extends \PHPUnit\Framework\TestCase
{
    function testNoClass()
    {
        $finder = new ClassFinder;

        $classes = $finder->find('<?php return;');
        $this->assertTrue(is_array($classes), 'Result is an array');
        $this->assertEmpty($classes, 'No class in source code returns an empty array');
    }

    function testNoNamespace()
    {
        $finder = new ClassFinder;

        $this->assertEquals(
                ['Foo'],
                $finder->find('<?php class Foo {}'), 'Single class without namespace');

        $this->assertEquals(
                ['Bar', 'Baz'],
                $finder->find('<?php class Bar {} class Baz {}'), 'Two classes without namespace');
    }

    function testGlobalNamespace()
    {
        $finder = new ClassFinder;

        $this->assertEquals(
                ['Wat'],
                $finder->find('<?php namespace { class Wat {} }'));

        $this->assertEquals(
                ['Alice', 'Bob'],
                $finder->find('<?php namespace { class Alice {} class Bob {} }'));
    }

    function testNamespace()
    {
        $finder = new ClassFinder;

        $this->assertEquals(
                ['My\\Example\\Name'],
                $finder->find('<?php namespace My\Example { class Name {} }'));

        $this->assertEquals(
                ['Another\\One', 'Another\\Two'],
                $finder->find('<?php namespace Another { class One {} class Two {} }'));
    }

    function testSeveralNamespaces()
    {
        $finder = new ClassFinder;

        $this->assertEquals(
                ['This\\Test', 'That\\Other\Test'],
                $finder->find('<?php namespace This { class Test {} } namespace That\Other { class Test {} }'));
    }

    function testClassSpecialConstant()
    {
        $finder = new ClassFinder;

        $this->assertEquals(
                ['FooBar'],
                $finder->find('<?php class FooBar {} echo FooBar::class;'));
    }
}
