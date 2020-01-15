[![Build Status](https://travis-ci.org/PanosCodes/Bnder.svg?branch=master)](https://travis-ci.org/PanosCodes/Bnder)

### 🤖 Bnder
___

Bnder is inspired by the Laravel factories, it is meant to be a quick and clean way
to create and persist and your Doctrine entities. It relies heavily on reflection class
providing a fluid api.

#### Example
```php
$properties = [
    'user' => new Entity(),
    'email' => 'sample@mail.local',
];

Bnder::registerFactory(Factory::create(SampleEntity::class, $properties))

// This will create an array of 3 
$entities = Bnder::load(YouFactory::class)->create(['email' => 'demo@mail.local'], 3);

```

