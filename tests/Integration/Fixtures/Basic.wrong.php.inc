<?php

namespace AlmaOss\CodingStandard\Integration\Fixtures;

// NoUnneededImportAliasFixer
use Bar\Foo as Foo;

class Basic extends \Some\Other\Namespace\AbstractBasic implements \AlmaOss\CodingStandard\Integration\Fixtures\InterfaceFromThisNamespace // FullyQualifiedStrictTypesFixer
{
    const FOO = 'foo'; // ClassAttributesSeparationFixer
    function isEqual($a, ? string $b): ? bool // VisibilityRequiredFixer, CompactNullableTypeDeclarationFixer
    {
        // TrimArraySpacesFixer
        $fooBar = [ 'a', 'b'];
        // NoTrailingCommaInSinglelineFixer
        mb_strlen('foobar', );
        // MbStrFunctionsFixer
        $bazLength = strlen('baz');
        // LambdaNotUsedImportFixer
        $lambdaWithUnusedImport = function () use ($fooBar) { return 'foo'; };
        // NoUselessSprintfFixer
        $uselessSprintf = sprintf('bar');
        // StrictParamFixer
        $useStrictParam = in_array(1337, $fooBar);
        // NoSpaceAroundDoubleColonFixer
        $className = DateTime :: class;
        // ClassReferenceNameCasingFixer
        $date = new \datetime();

        $aliasedClass = new Foo();

        // SingleSpaceAfterConstructFixer, StrictComparisonFixer
        if ($a == $b || $bazLength != 3) { return  true; }
        return false; // BlankLineBeforeStatementFixer
    }

    public const MY_PUBLIC_CONST = 333; // OrderedClassElementsFixer

    public function fooBar ( mixed    $foo ): mixed // FunctionDeclarationFixer
    {
        // MagicConstantCasingFixer
        $magicConstant = __dir__;
        $value = 5;
        // FunctionDeclarationFixer
        $function = function($foo)use($value) {
            return $foo + $value;
        };
        // FunctionDeclarationFixer
        $fn = fn ($foo) => $foo + $value;

        // PhpdocToCommentFixer
        /**
         * Phpdoc used instead of plain comment
         */
        if ($foo === 'bar') {
            // NoAliasFunctionsFixer
            $baz = join(',', ['foo', 'bar']);
        }

        $i = 3;
        $i = $i + 6; // LongToShorthandOperatorFixer
        $i = $i * 2; // LongToShorthandOperatorFixer
        $text = 'foo';
        $text = $text . 'bar'; // LongToShorthandOperatorFixer

        switch ($i) {
            case (1): // NoUnneededControlParenthesesFixer
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
        return ($foo ? $foo : 'not true');
    }

    protected int $myProperty = 666; // OrderedClassElementsFixer

    use SomeUsefulTrait; // OrderedClassElementsFixer

    public function arrayDeclarations(): void
    {
        $empty = array();

        $singleLineArray = ['foo', 'bar', 'baz',];
        $singleLineArray2 = [1,2,3];

        $multiLineAssociative1 = [
            'foo' => 'bar', 'baz' => 'bat',
        ];

        $multiLineAssociative2 = [
            'foo'=>'bar',
                'baz'=>'bat',
        'bak'=>'baz'
        ];

        $multiLineAssociative3 = [
            'firstKey'        => 'bar',
            'thisIsSecondKey' => 'bat',
            'third'           => 'bat',
        ];
    }

    public function emptyFunction1(): void {
    } // SingleLineEmptyBodyFixer

    public function emptyFunction2(
        $arg
    ): void {
    } // SingleLineEmptyBodyFixer

    // TrailingCommaInMultilineFixer
    public function multiline(
        $arg1,
            $arg2,
        $arg3
    ): void
    {
        // TrailingCommaInMultilineFixer
        $isSet = isset(
            $arg1,
            $arg2,
            $arg3
        );

        $sprintf = sprintf(
            '%s%s',
            'bar',
            'baz'
        );

        foo(
            1,
            2
        );
    }

    public function withParameters(
        // NullableTypeDeclarationFixer
        null|string $nullableValue,
        // NullableTypeDeclarationForDefaultNullValueFixer
        string $anotherNullableValue = null,
    ): void {}

    // MagicMethodCasingFixer, OrderedClassElementsFixer
    public function __ToString(): string
    {
        return '';
    }
}
