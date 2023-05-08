## PHP Identicon Generator

Based and inspired on
- [github_avatars_generator](https://github.com/avdosev/github_avatars_generator) (matrix)
- [identicon](https://github.com/dgraham/identicon) (color)

### Installation

```
composer require usarise/identicon
```

### Usage
```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Identicon\Identicon;
use Identicon\ImageDriver\{GdDriver, ImagickDriver};

header('Content-type: image/png');

$identicon = new Identicon(
    new GdDriver(), // or new ImagickDriver()
);

echo $identicon->generate('test');
```
