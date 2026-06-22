# PHP Identicon Generator

[![Latest Version](https://img.shields.io/github/v/release/usarise/identicon-php.svg?style=flat-square&logo=semver)](https://github.com/usarise/identicon-php/releases)
[![PHP Version](https://img.shields.io/packagist/dependency-v/usarise/identicon/php.svg?colorB=%238892BF&style=flat-square&logo=php&logoColor=fff)](https://php.net)
[![License](https://img.shields.io/github/license/usarise/identicon-php?style=flat-square&colorB=darkcyan&logo=unlicense&logoColor=fff)](LICENSE)
[![Total Downloads](https://img.shields.io/packagist/dt/usarise/identicon.svg?style=flat-square&logo=packagist&logoColor=fff)](https://packagist.org/packages/usarise/identicon)
[![GitHub CI](https://img.shields.io/github/actions/workflow/status/usarise/identicon-php/ci.yml?style=flat-square&logo=github&label=GitHub%20CI)](https://github.com/usarise/identicon-php/actions/workflows/ci.yml)

Based and inspired on
- [github_avatars_generator](https://github.com/avdosev/github_avatars_generator) (matrix)
- [identicon](https://github.com/dgraham/identicon) (color)

![test](https://user-images.githubusercontent.com/7043681/236885701-fc99d5e4-0d6e-488d-82f7-dddefb9335d2.png)

## Installation

```
composer require usarise/identicon
```

## Usage browser
```php
<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Usarise\Identicon\Identicon;
use Usarise\Identicon\Image\Svg\Canvas as SvgCanvas;

$identicon = new Identicon(
    new SvgCanvas(),
    420,
);

$response = $identicon->generate('test');

header("Content-type: {$response->mimeType}");
echo (string) $response;
```

## Usage write file
```php
<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Usarise\Identicon\Identicon;
use Usarise\Identicon\Image\Svg\Canvas as SvgCanvas;

$identicon = new Identicon(
    new SvgCanvas(),
    420,
);

$response = $identicon->generate('test');
$response->save("test.{$response->format}");
```

## Usage data url
```php
<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Usarise\Identicon\Identicon;
use Usarise\Identicon\Image\Svg\Canvas as SvgCanvas;

$identicon = new Identicon(
    new SvgCanvas(),
    420,
);

$response = $identicon->generate('test');
$data = sprintf(
    'data:%s;base64,%s',
    $response->mimeType,
    base64_encode(
        (string) $response,
    ),
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Identicon Data URL example</title>
</head>
<body>
  <img src="<?php echo $data; ?>" />
</body>
</html>
```

## Usage advanched
### Construct
```php
use Usarise\Identicon\Image\Svg\Canvas as SvgCanvas;
use Usarise\Identicon\{Identicon, Resolution};

$identicon = new Identicon(
    image: new SvgCanvas(), // implementation Usarise\Identicon\Image\CanvasInterface
    size: 420, // 420x420 pixels
    resolution: Resolution::Medium, // Resolution 10x10 (Default)
    sizeNonStrict: false, // size must be a multiple of the resolution (Default)
);
```
### Image Canvas
Implementations `Usarise\Identicon\Image\CanvasInterface` from the box
```php
use Usarise\Identicon\Image\Gd\Canvas as GdCanvas;
use Usarise\Identicon\Image\Imagick\Canvas as ImagickCanvas;
use Usarise\Identicon\Image\Vips\Canvas as VipsCanvas;
use Usarise\Identicon\Image\Svg\Canvas as SvgCanvas;
```
#### Gd extension ([libgd](https://github.com/libgd/libgd))
```php
new GdCanvas()
```
#### [Imagick](https://github.com/Imagick/imagick) extension ([ImageMagick](https://github.com/ImageMagick/ImageMagick))
```php
new ImagickCanvas()
```
#### [jcupitt/vips](https://github.com/libvips/php-vips) ([libvips](https://github.com/libvips/libvips))
```php
new VipsCanvas()
```
Sample use specify path to libvips:
```php
new VipsCanvas(libvipsPath: 'C:/vips-dev-8.18/bin')
```
> Recommended for Windows
#### SVG
```php
new SvgCanvas()
```
### Size
Output image height and width

If `sizeNonStrict` = `false`: must be a positive multiple of the resolution

**Example**: 120 for resolution `Resolution::Medium`
and
126 for resolution `Resolution::Large`
### Resolutions
Pixel resolution of the pattern identicon
```php
use Usarise\Identicon\Resolution;
```
#### 6x6 (Tiny)
![Tiny](https://github.com/usarise/identicon-php/blob/main/tests/Image/fixtures/resolution/r.tiny.imagick.png?raw=true)
```php
Resolution::Tiny
```
#### 8x8 (Small)
![Small](https://github.com/usarise/identicon-php/blob/main/tests/Image/fixtures/resolution/r.small.imagick.png?raw=true)
```php
Resolution::Small
```
#### 10x10 (Medium)
![Medium](https://github.com/usarise/identicon-php/blob/main/tests/Image/fixtures/resolution/r.medium.imagick.png?raw=true)
```php
Resolution::Medium
```
#### 12x12 (Large)
![Large](https://github.com/usarise/identicon-php/blob/main/tests/Image/fixtures/resolution/r.large.imagick.png?raw=true)
```php
Resolution::Large
```
#### 14x14 (Huge)
![Huge](https://github.com/usarise/identicon-php/blob/main/tests/Image/fixtures/resolution/r.huge.imagick.png?raw=true)
```php
Resolution::Huge
```
### Size non strict
Allows you to use any size, adjusting the drawing to it

**Example**: size `126` for resolution `Resolution::Medium`

![sizeNonStrict](https://github.com/usarise/identicon-php/blob/main/tests/Image/fixtures/sizeNonStrict/test.imagick.png?raw=true)
### Generate
#### String
Username, id, email, ip, etc
```php
$response = $identicon->generate(string: 'test')
```
#### Background
CSS 6-digit or 3-digit hex color
```php
$response = $identicon->generate(string: 'test', background: '#f2f1f2')
```
#### Foreground
CSS 6-digit or 3-digit hex color
```php
$response = $identicon->generate(string: 'test', foreground: '#84c7b5')
```
#### Background and Foreground
CSS 6-digit or 3-digit hex color
```php
$response = $identicon->generate(string: 'test', background: '#f2f1f2', foreground: '#84c7b5')
```
### Response
#### Format
`png`, `svg`, other custom
```php
$response->format // svg
```
#### Mime type
`image/png`, `image/svg+xml`, other custom
```php
$response->mimeType // image/svg+xml
```
#### Output string
Compressed image
```php
$response->output
```
#### Alternative `$response->output`: response object to string
Compressed image
```php
(string) $response
```
#### Uncompressed image
`object`, `string`, `null`
```php
$response->image // object
```
#### Save file
Allowed file extension only `$response->format`
```php
$response->save(path: __DIR__ . '/test.svg')
```
