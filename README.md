## PHP Identicon Generator

Based and inspired on
- [github_avatars_generator](https://github.com/avdosev/github_avatars_generator) (matrix)
- [identicon](https://github.com/dgraham/identicon) (color)

![test](https://user-images.githubusercontent.com/7043681/236885701-fc99d5e4-0d6e-488d-82f7-dddefb9335d2.png)

### Installation

```
composer require usarise/identicon
```

### Usage
```php
<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Usarise\Identicon\Identicon;
use Usarise\Identicon\ImageDriver\GdDriver;

$identicon = new Identicon(
    new GdDriver(),
    420,
);

header('Content-type: image/png');
echo $identicon->generate('test');
```
