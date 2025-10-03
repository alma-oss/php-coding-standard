<?php

declare(strict_types=1);

namespace Lmc\CodingStandard\Integration\Fixtures;

// NoUnneededImportAliasFixer
use Bar\Foo;
use Some\Other\Namespace\AbstractBasic;

class Basic extends AbstractBasic implements InterfaceFromThisNamespace // FullyQualifiedStrictTypesFixer
{
    use SomeUsefulTrait; // OrderedClassElementsFixer
    public const FOO = 'foo'; // ClassAttributesSeparationFixer

    public const MY_PUBLIC_CONST = 333; // OrderedClassElementsFixer

    protected int $myProperty = 666; // OrderedClassElementsFixer

    // MagicMethodCasingFixer, OrderedClassElementsFixer
    public function __toString(): string
    {
        return '';
    }

    public function isEqual($a, ?string $b): ?bool // VisibilityRequiredFixer, CompactNullableTypeDeclarationFixer
    {
        // TrimArraySpacesFixer
        $fooBar = ['a', 'b'];
        // NoTrailingCommaInSinglelineFixer
        mb_strlen('foobar');
        // MbStrFunctionsFixer
        $bazLength = mb_strlen('baz');
        // LambdaNotUsedImportFixer
        $lambdaWithUnusedImport = function () { return 'foo'; };
        // NoUselessSprintfFixer
        $uselessSprintf = 'bar';
        // StrictParamFixer
        $useStrictParam = in_array(1337, $fooBar, true);
        // NoSpaceAroundDoubleColonFixer
        $className = DateTime::class;
        // ClassReferenceNameCasingFixer
        $date = new \DateTime();

        $aliasedClass = new Foo();

        // SingleSpaceAfterConstructFixer, StrictComparisonFixer
        if ($a === $b || $bazLength !== 3) {
            return true;
        }

        return false; // BlankLineBeforeStatementFixer
    }

    public function fooBar(mixed $foo): mixed // FunctionDeclarationFixer
    {
        // MagicConstantCasingFixer
        $magicConstant = __DIR__;
        $value = 5;
        // FunctionDeclarationFixer
        $function = function ($foo) use ($value) {
            return $foo + $value;
        };
        // FunctionDeclarationFixer
        $fn = fn($foo) => $foo + $value;

        // PhpdocToCommentFixer
        /*
         * Phpdoc used instead of plain comment
         */
        if ($foo === 'bar') {
            // NoAliasFunctionsFixer
            $baz = implode(',', ['foo', 'bar']);
        }

        $i = 3;
        $i += 6; // LongToShorthandOperatorFixer
        $i *= 2; // LongToShorthandOperatorFixer
        $text = 'foo';
        $text .= 'bar'; // LongToShorthandOperatorFixer

        switch ($i) {
            case 1: // NoUnneededControlParenthesesFixer
                $i++;
                break;
            default:
                break;
        }

        // HeredocIndentationFixer
        $heredoc = <<<HEREDOC
            This is a
            multiline heredoc string. It contains $foo.
            It should be indented, though.
            HEREDOC;
        // HeredocIndentationFixer
        $newdoc = <<<'NEWDOC'
            This is a $newdoc, where variables are not expanded.
            NEWDOC;

        // TernaryToElvisOperatorFixer
        return ($foo ?: 'not true');
    }

    public function arrayDeclarations(): void
    {
        $empty = [];

        $singleLineArray = ['foo', 'bar', 'baz'];
        $singleLineArray2 = [1, 2, 3];

        $multiLineAssociative1 = [
            'foo' => 'bar',
            'baz' => 'bat',
        ];

        $multiLineAssociative2 = [
            'foo' => 'bar',
            'baz' => 'bat',
            'bak' => 'baz',
        ];

        $multiLineAssociative3 = [
            'firstKey' => 'bar',
            'thisIsSecondKey' => 'bat',
            'third' => 'bat',
        ];
    }

    public function emptyFunction1(): void {} // SingleLineEmptyBodyFixer

    public function emptyFunction2(
        $arg,
    ): void {} // SingleLineEmptyBodyFixer

    // TrailingCommaInMultilineFixer
    public function multiline(
        $arg1,
        $arg2,
        $arg3,
    ): void {
        // TrailingCommaInMultilineFixer
        $isSet = isset(
            $arg1,
            $arg2,
            $arg3,
        );

        $sprintf = sprintf(
            '%s%s',
            'bar',
            'baz',
        );

        foo(
            1,
            2,
        );
    }

    public function withParameters(
        // NullableTypeDeclarationFixer
        ?string $nullableValue,
        // NullableTypeDeclarationForDefaultNullValueFixer
        ?string $anotherNullableValue = null,
    ): void {}
}
