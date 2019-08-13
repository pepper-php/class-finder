# `pepper/class-finder` [![Build Status](https://travis-ci.org/pepper/class-finder.svg?branch=master)](https://travis-ci.org/pepper/class-finder)

## Installation

The recommended way to install [`pepper/class-finder`](https://github.com/pepper/class-finder) is through [Composer](https://getcomposer.org).

```shell
$ composer require pepper/class-finder
```

## Usage

```php
use Pepper\ClassFinder\ClassFinder;

$classes = (new ClassFinder)->find('
<?php

namespace Polite;

class Person
{
    function sayHello() {
        echo "Hello world!";
    }
}
');

print_r($classes);

// Array
// (
//     [0] => Polite\Person
// )
```
