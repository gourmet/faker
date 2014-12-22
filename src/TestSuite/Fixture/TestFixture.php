<?php

namespace Gourmet\Faker\TestSuite\Fixture;

use Cake\Database\Connection;
use Cake\TestSuite\Fixture\TestFixture as CakeTestFixture;
use Faker\Factory as Faker;
use Faker\ORM\CakePHP\EntityPopulator;
use Faker\ORM\CakePHP\Populator;

class TestFixture extends CakeTestFixture {

/**
 * Instance of Faker's generator.
 *
 * @var Faker\Generator
 */
	public $faker;

/**
 * Number of records to auto-generate.
 *
 * @var int
 */
	public $number;

/**
 * Guessers to add.
 *
 * @var array
 */
	public $guessers = [];

/**
 * Custom column formatters to apply.
 *
 * @var array
 */
	public $customColumnFormatters = [];

/**
 * Custom modifiers to apply.
 *
 * @var array
 */
	public $customModifiers = [];

/**
 * {@inheritdoc}
 */
	public function __construct() {
		$this->faker = Faker::create();
		parent::__construct();
	}

/**
 * {@inheritdoc}
 */
	public function insert(Connection $db) {
		if (!parent::insert($db)) {
			return false;
		}

		$entityPopulator = new EntityPopulator($this->table);
		$populator = new Populator($this->faker);
		array_walk($this->guessers, array($populator, 'addGuesser'));
		$populator->addEntity($entityPopulator, $this->number, $this->customColumnFormatters, $this->customModifiers);
		$populator->execute(['validate' => false]);
		return true;
	}

}
