<?php

namespace Adagio\Tests\ClassFinder;

use Adagio\ClassFinder\ClassFinder;

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

        $classes = $finder->find('<?php class Foo {}');
        $this->assertEquals(['Foo'], $classes);

        $classes = $finder->find('<?php class Foo {} class Bar {}');
        $this->assertEquals(['Foo', 'Bar'], $classes);
    }

    function testGlobalNamespace()
    {
        $finder = new ClassFinder;

        $classes = $finder->find('<?php namespace { class Foo {} }');
        $this->assertEquals(['Foo'], $classes);

        $classes = $finder->find('<?php namespace { class Foo {} class Bar {} }');
        $this->assertEquals(['Foo', 'Bar'], $classes);
    }

    function testNamespace()
    {
        $finder = new ClassFinder;

        $classes = $finder->find('<?php namespace Foo { class Bar {} }');
        $this->assertEquals(['Foo\\Bar'], $classes);

        $classes = $finder->find('<?php namespace Foo { class Bar {} class Baz {} }');
        $this->assertEquals(['Foo\\Bar', 'Foo\\Baz'], $classes);
    }

    function testSeveralNamespaces()
    {
        $finder = new ClassFinder;

        $classes = $finder->find('<?php namespace Foo { class Bar {} } namespace Baz { class Bar {} }');
        $this->assertEquals(['Foo\\Bar', 'Baz\\Bar'], $classes);
    }
}