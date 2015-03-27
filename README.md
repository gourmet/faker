# Faker

[![Total Downloads](https://poser.pugx.org/gourmet/faker/downloads.svg)](https://packagist.org/packages/gourmet/faker)
[![License](https://poser.pugx.org/gourmet/faker/license.svg)](https://packagist.org/packages/gourmet/faker)

Built to enable [Faker] support in [CakePHP 3].

## Install

Using [Composer]:

```
composer require gourmet/faker:~1.0
```

You then need to load the plugin. In `boostrap.php`, something like:

```php
\Cake\Core\Plugin::load('Gourmet/Faker');
```

## Examples

### Fixture

```php
<?php

namespace App\Test\Fixture;

use Gourmet\Faker\TestSuite\Fixture\TestFixture;

class PostsFixture extends TestFixture {

    public $fields = [
        'id' => ['type' => 'integer'],
        'title' => ['type' => 'string', 'length' => 255, 'null' => false],
        'body' => 'text',
        'published' => ['type' => 'integer', 'default' => '0', 'null' => false],
        'created' => 'datetime',
        'updated' => 'datetime',
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id']]
        ]
    ];

    public $records = [
        [
            'id' => 1,
            'title' => 'First Article',
            'body' => 'First Article Body',
            'published' => '1',
            'created' => '2007-03-18 10:39:23',
            'updated' => '2007-03-18 10:41:31'
        ],
        [
            'id' => 2,
            'title' => 'Second Article',
            'body' => 'Second Article Body',
            'published' => '1',
            'created' => '2007-03-18 10:41:23',
            'updated' => '2007-03-18 10:43:31'
        ],
        [
            'id' => 3,
            'title' => 'Third Article',
            'body' => 'Third Article Body',
            'published' => '1',
            'created' => '2007-03-18 10:43:23',
            'updated' => '2007-03-18 10:45:31'
        ]
    ];

    public $number = 20;
    public $guessers = ['\Faker\Guesser\Name'];

    public function init() {
        $this->customColumnFormatters = [
            'id' => function () { return $this->faker->numberBetween(count($this->records) + 2); },
            'published' => function () { return rand(0,3); }
        ];
        parent::init();
    }
}
```

### Migration

```php
<?php

use Phinx\Migration\AbstractMigration;

class SeedDataMigration extends AbstractMigration {
    public function up() {
        $faker = Faker::create();
        $populator = new Populator($faker);
        $populator->addGuesser('\Faker\Guesser\Name');

        $created = $modified = function () use ($faker) {
            static $beacon;
            $ret = $beacon;
            if (empty($ret)) {
                return $beacon = $faker->dateTimeThisDecade();
            }
            $beacon = null;
            return $ret;
        }
        $timestamp = compact('created', 'modified');

        $roles = ['admin', 'editor', 'member'];

        $populator->addEntity('Users', 100, [
            'email' => function () use ($faker) { return $faker->safeEmail(); },
            'first_name' => function () use ($faker) { return $faker->firstName(); },
            'last_name' => function () use ($faker) { return $faker->lastName(); },
            'timezone' => function () use ($faker) { return $faker->timezone(); },
            'role' => function () use ($roles) { return $roles[array_rand($roles)]; }
        ] + $timestamp);

        $populator->execute(['validate' => false]);
    }
}
```

## License

Copyright (c)2015, Jad Bitar and licensed under [The MIT License][mit].

[CakePHP 3]:http://cakephp.org
[Composer]:http://getcomposer.org
[mit]:http://www.opensource.org/licenses/mit-license.php
[Faker]:https://github.com/fzaninotto/Faker
