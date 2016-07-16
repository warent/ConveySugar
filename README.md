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
				'SUGAR_URL' => 'https://sugar/rest/v10/',
				'SUGAR_USERNAME' => 'admin',
				'SUGAR_PASS' => 'password'
			]);
		}

		public function searchContacts() {

			// Instantiating a new Sugar Utility
			// This one cycles through all instances of a Sugar module
			$serchUtil = new Search(['processFn' => function($Results, $offset) {
				echo "Results from $offset";
				foreach ($Results as $result) {
					print_r($Result);
				}
			});

			// We execute our Sugar Utility on the module 'Contacts'
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
* None

### Delete
#### Description
	Delete a record by ID
#### Parameters
* recordID __(Sugar ID [string]) _Required___

### Insert
#### Description
	Insert a new record
#### Parameters
* values __(Assoc Array) _Required___

### Related
#### Description
	Cycle related records of one sugar record to another module
#### Parameters
* recordID __(Sugar ID [string]) _Required___
* relation __(Sugar Module [string]) _Required___
* type __(Related::Type [static int])__
	* Related::TYPE_NORMAL
	* Related::TYPE_NAKED
	* Related::TYPE_BACK
* transform __(Related::Transform [static int])__
	* Related::TRANSFORM_JSON
	* Related::TRANSFORM_BOOL
* resultFn __(Function)__
	* Parameters (Assoc Array)
		* results
		* offset
* offset __(Integer)__
* limit __(Integer)__

### Search
#### Description
	Cycle records of a sugar module
#### Parameters
* resultFn __(Function) _Required___
	* Parameters (Assoc Array)
		* results
		* offset
* offset __(Integer)__
* limit __(Integer)__

## Thank you
* [SPinegar SugarCRM REST Client For SugarCRM 7](https://github.com/spinegar/sugarcrm7-api-wrapper-class)
* [Convey Studio](http://www.conveystudio.com/)
* [SugarCRM](https://www.sugarcrm.com/)
