[![Build Status](https://travis-ci.org/PanosCodes/Bender.svg?branch=master)](https://travis-ci.org/PanosCodes/Bender)

### Bender
___

Bender is inspired by the Laravel factories, it is meant to be a quick and clean way
to create and persist and your Doctrine entities. It relies heavily in providing a fluid api.

#### Example
``
Bender::load(YouFactory::class)->create(['email' => 'demo@demo.demo'], 3);
``

