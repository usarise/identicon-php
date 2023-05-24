<?php

declare(strict_types=1);

namespace Usarise\Identicon;

final class Response implements \Stringable {
    public function __construct(
        public readonly string $format,
        public readonly string $output,
    ) {
    }

    public function save(string $path): void {
        file_put_contents(
            $path,
            $this->output,
            LOCK_EX,
        );
    }

    public function __toString(): string {
        return $this->output;
    }
}
