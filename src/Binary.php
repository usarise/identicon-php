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
     * @return non-empty-array<int<1, 16>, int<0, 255>>
     */
    public function getBytes(string $str): array {
        $bytes = (array) unpack('C*', hash('md5', $str, true));

        if (\count($bytes) !== 16) {
            throw new RuntimeException('unpack failure');
        }

        return $bytes;
    }

    /**
     * @param non-empty-array<int<1, 16>, int<0, 255>> $bytes
     */
    public function getBinStr(array $bytes): string {
        $resolution = $this->resolution->value;

        $byteToBin = static fn (int $byte): string => str_pad(
            string: decbin(
                $byte,
            ),
            length: 8,
            pad_string: '0',
            pad_type: STR_PAD_LEFT,
        );

        return substr(
            string: implode(
                separator: '',
                array: array_map(
                    callback: $byteToBin,
                    array: $bytes,
                ),
            ),
            offset: 0,
            length: $resolution * ($resolution / 2),
        );
    }

    /**
     * @return array<int, non-empty-array<int, int<0, 1>>>
     */
    public function getPixels(string $binStr): array {
        $binaryList = str_split($binStr);
        $resolution = $this->resolution->value;

        $matrix = [];
        $level = 0;

        foreach ($binaryList as $key => $value) {
            $levelEnd = ($key + 1) % $resolution === 0;

            $matrix[$level][] = match (true) {
                // Entry level is padding
                $level === 0 => 0,
                // Level start is padding
                $key % $resolution === 0 => 0,
                // Level end is padding
                $levelEnd => 0,
                // Converting string to binary number
                default => (int) $value,
            };

            if ($levelEnd) {
                ++$level;
            }
        }

        return [
            ...$matrix,
            ...array_reverse($matrix),
        ];
    }
}
