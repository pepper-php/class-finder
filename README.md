# `adagio/class-finder` [![Build Status](https://travis-ci.org/adagiolabs/class-finder.svg?branch=master)](https://travis-ci.org/adagiolabs/class-finder)

## Installation

The recommended way to install [`adagio/class-finder`](https://github.com/adagiolabs/class-finder) is through [Composer](https://getcomposer.org).

```shell
$ composer require adagio/class-finder
```

## Usage

```php
use Adagio\ClassFinder\ClassFinder;

$classes = (new ClassFinder)->find('<?php

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
