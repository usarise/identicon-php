<?php

declare(strict_types=1);

namespace Usarise\Identicon;

use Usarise\Identicon\Exception\RuntimeException;

final class Binary {
    public function __construct(
        private readonly Resolution $resolution,
    ) {
    }

    /**
     * @return non-empty-array<int, int>
     */
    public function getBytes(string $str): array {
        $bytes = (array) unpack('C*', hash('md5', $str, true));

        if (\count($bytes) !== 16) {
            throw new RuntimeException('unpack failure');
        }

        return $bytes;
    }

    /**
     * @param non-empty-array<int, int> $bytes
     */
    public function getBinStr(array $bytes): string {
        $resolution = $this->resolution->value;

        return substr(
            string: implode(
                separator: '',
                array: array_map(
                    callback: $this->byteToBin(...),
                    array: $bytes,
                ),
            ),
            offset: 0,
            length: $resolution * ($resolution / 2),
        );
    }

    /**
     * @return non-empty-array<int, array>
     */
    public function getPixels(string $binStr): array {
        $binSplit = str_split($binStr);

        $matrix = [];
        $count = 0;
        $level = 0;

        $resolution = $this->resolution->value;

        foreach ($binSplit as $bin) {
            $matrix[$level][] = (int) $bin;

            if (++$count % $resolution === 0) {
                $level++;
            }
        }

        $pixels = [
            ...$matrix,
            ...array_reverse($matrix),
        ];

        // Resolution calculation in the template starts from zero
        --$resolution;

        // Removing blocks at the edges
        foreach (range(0, $this->resolution->value) as $i) {
            $pixels[0][$i] = 0;
            $pixels[$resolution][$i] = 0;
            $pixels[$i][0] = 0;
            $pixels[$i][$resolution] = 0;
        }

        return $pixels;
    }

    private function byteToBin(int $byte): string {
        return str_pad(
            string: decbin(
                $byte,
            ),
            length: 8,
            pad_string: '0',
            pad_type: STR_PAD_LEFT,
        );
    }
}
