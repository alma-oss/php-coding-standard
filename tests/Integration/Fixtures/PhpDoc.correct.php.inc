<?php

declare(strict_types=1);

namespace Lmc\CodingStandard\Integration\Fixtures;

class PhpDoc
{
    // PhpdocToPropertyTypeFixer, PropertyTypeHintSniff
    private int $integerValue = 3;
    private $undefinedTypeValue = 3;
    private mixed $undeclaredMixedType;
    private \DateTimeImmutable $nonScalarType;

    /**
     * Very well documented method.
     * It tests PhpdocAlignFixer, NoSuperfluousPhpdocTagsFixer, PhpdocTrimConsecutiveBlankLineSeparationFixer
     * and possibly other Phpdoc rules.
     *
     * @param int|float $second Second parameter does have a comment, unlike the first one.
     * @param string|null $third Third parameter is optional and has a default value and multilne comment. Lorem
     * ipsum dolor sit amet, consectetur adipiscing elit. Nullam nec purus nec nunc ultricies ultricies.
     * Nullam nec purus nec nunc ultricies ultricies. Nullam nec purus nec nunc ultricies ultricies.
     * @return mixed There is also information about return type.
     * @throws \Exception
     */
    public function veryWellDocumented(string $first, int|float $second, ?string $third = '3rd'): mixed
    {
        return $first . $third;
    }

    public function methodWithTypesInTypeHints(int $value, mixed $mixedType): bool
    {
        return $value > 3 ? true : false;
    }

    /**
     * @param string $stringParam This phpdoc should be preserved, because it contains some comment for $stringParam.
     */
    public function methodWithMeaningfulParamComment(int $intParam, string $stringParam): void
    {
        // Do nothing.
    }
}
