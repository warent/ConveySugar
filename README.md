# ConveySugar
License: MIT

## 1. About
* Designed to work with SugarCRM 7 and the v10 REST API

## 2. Installation
ConveySugar is available via Composer
`$ composer require warent/convey-sugar`

## 3. Usage Examples
```php
<?php

	namespace App;

	use ConveySugar\Sugar;
	use ConveySugar\Utilities\Search;

	class ContactSearchingApp {

		private $sugar;

		public function __construct() {
			// Creating our Sugar connection instance.
			// Connection opens when newed up,
			// so be sure accepting functions accept sugar by reference.
			$this->sugar = new Sugar([
				'SUGAR_URL' => 'http://sugar-url.com',
				'SUGAR_USERNAME' => 'admin',
				'SUGAR_PASS' => 'password'
			]);
		}

		public function searchContacts() {

			$serchUtil = new Search(['processFn' => function($Results, $offset) {
				echo "Results from $offset";
				foreach ($Results as $result) {
					print_r($Result);
				}
			});

			$this->sugar->execute('Contacts', $searchUtil);
		}
	}
?>
```

## 4. Utilities
### Count
#### Description
	Return the number of records within a sugar module
#### Parameters
	None

### Delete
#### Description
	Delete a record by ID
#### Parameters


### Insert
#### Description
	Insert a new record
#### Parameters


### Related
#### Description
	Cycle related records of one sugar record to another module
#### Parameters


### Search
#### Description
	Cycle records of a sugar module
#### Parameters
