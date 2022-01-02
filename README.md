# PHP Face Detection

This class can detect one face in images ATM.

This is a pure PHP port of existing JS code from Karthik Tharavaad.

Since the package was abandoned by the original author, I forked it and upgraded
it to be compatible with PHP 7.4.

## Requirements
PHP7.3 or higher with GD

## License
GNU GPL v2 (See LICENSE.txt)

## Installation
Composer (recommended):

```sh
$ composer require sensimedia/facial
```

## Usage
```php
<?php

use Sensi\Facial\Detector;

$detector = new Detector;
$hasFace = $detector->fromFile('/path/to/file')->detectFace();
var_dump($hasFace);
```

