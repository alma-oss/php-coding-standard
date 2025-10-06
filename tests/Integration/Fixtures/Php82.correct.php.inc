<?php

declare(strict_types=1);

namespace AlmaOss\CodingStandard\Integration\Fixtures;

class Php82
{
    public function php82features(): void
    {
        $name = 'John';
        $complexString = "Hello {$name}!";
    }
}
