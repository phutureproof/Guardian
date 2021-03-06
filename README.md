Guardian
=

Build Status
--

Master

[![Build Status](https://travis-ci.org/phutureproof/Guardian.svg?branch=master)](https://travis-ci.org/phutureproof/Guardian)


Develop

[![Build Status](https://travis-ci.org/phutureproof/Guardian.svg?branch=develop)](https://travis-ci.org/phutureproof/Guardian)

Code Climate

[![Code Climate](https://codeclimate.com/github/phutureproof/Guardian/badges/gpa.svg)](https://codeclimate.com/github/phutureproof/Guardian)

Basic Usage
=

Installation
-

via composer

    composer require phutureproof/guardian

or add this to your composer.json

    "require": {
      "phutureproof/guardian": "~3"
    }

or manually grab the src folder and put the files where ever you want.

Usage
-

Create your dependencies and register functions to return instances of the objects in the container

    Guardian::register('dependency.name', function()
    {
        return new Dependency();
    });

Grab an instance of the dependency

    $instance = Guardian::make('dependency.name');

Register a singleton

    Guardian::register('singleton.dependency.name', function () {
        static $instance;
        if (is_null($instance)) {
            $instance = new Dependency();
        }
        return $instance;
    });
