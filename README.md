# Faker

Built to enable [Faker] support in [CakePHP][cakephp].

## Requirements

* CakePHP 3.x
* Faker

## Install

Using [Composer][composer]:

```
composer require gourmet/faker
```

Because this plugin has the type `cakephp-plugin` set in its own `composer.json`,
[Composer][composer] will install it inside your /plugins directory, rather than
in your `vendor-dir`. It is recommended that you add /plugins/gourmet/liquid to your
`.gitignore` file and here's [why][composer:ignore].

You then need to load the plugin. In `boostrap.php`, something like:

```php
\Cake\Core\Plugin::load('Gourmet/Faker');
```
## Create a fixture

```
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

In the meantime, read more about the library this plugin wraps over [here][Faker].

That's it!

## License

Copyright (c) 2014, Jad Bitar and licensed under [The MIT License][mit].

[cakephp]:http://cakephp.org
[composer]:http://getcomposer.org
[composer:ignore]:http://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md
[mit]:http://www.opensource.org/licenses/mit-license.php
[Faker]:https://github.com/fzaninotto/Faker
