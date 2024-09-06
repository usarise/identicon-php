<?php

declare(strict_types=1);

namespace Usarise\Identicon;

/**
 * @api
 */
enum Resolution: int {
    case Tiny = 8;
    case Small = 10;
    case Medium = 12;
    case Large = 14;
    case Huge = 16;
}
