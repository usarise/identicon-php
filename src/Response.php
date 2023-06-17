<?php

declare(strict_types=1);

namespace Usarise\Identicon;

use Usarise\Identicon\Exception\RuntimeException;

final class Response implements \Stringable {
    public function __construct(
        public readonly string $format,
        public readonly string $mimeType,
        public readonly string $output,
    ) {
    }

    public function save(string $path): void {
        if (file_put_contents(
            $path,
            $this->output,
            LOCK_EX,
        ) === false) {
            throw new RuntimeException(
                'Failed write image to file',
            );
        }
    }

    public function __toString(): string {
        return $this->output;
    }
}
