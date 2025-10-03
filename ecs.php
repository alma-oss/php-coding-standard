<?php

declare(strict_types=1);

use Lmc\CodingStandard\Fixer\SpecifyArgSeparatorFixer;
use Lmc\CodingStandard\Sniffs\Naming\AbstractClassNameSniff;
use Lmc\CodingStandard\Sniffs\Naming\ClassNameSuffixByParentSniff;
use Lmc\CodingStandard\Sniffs\Naming\InterfaceNameSniff;
use Lmc\CodingStandard\Sniffs\Naming\TraitNameSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Classes\DuplicateClassNameSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\EmptyStatementSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\ForLoopShouldBeWhileLoopSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\JumbledIncrementerSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\UnconditionalIfStatementSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\UnnecessaryFinalModifierSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\UselessOverridingMethodSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Commenting\DocCommentSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\OneClassPerFileSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\OneInterfacePerFileSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\OneTraitPerFileSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterCastSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\VersionControl\GitMergeConflictSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Arrays\ArrayBracketSpacingSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Arrays\ArrayDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\SelfMemberReferenceSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Commenting\DocCommentAlignmentSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Commenting\EmptyCatchCommentSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Operators\IncrementDecrementUsageSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Scope\MemberVarScopeSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\CastSpacingSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\LanguageConstructSpacingSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\LogicalOperatorSpacingSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\OperatorSpacingSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\ScopeClosingBraceSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\ScopeKeywordSpacingSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\SemicolonSpacingSniff;
use PhpCsFixer\Fixer\Alias\ArrayPushFixer;
use PhpCsFixer\Fixer\Alias\MbStrFunctionsFixer;
use PhpCsFixer\Fixer\Alias\NoAliasFunctionsFixer;
use PhpCsFixer\Fixer\Alias\RandomApiMigrationFixer;
use PhpCsFixer\Fixer\Alias\SetTypeToCastFixer;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ArrayNotation\NormalizeIndexBraceFixer;
use PhpCsFixer\Fixer\ArrayNotation\TrimArraySpacesFixer;
use PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer;
use PhpCsFixer\Fixer\AttributeNotation\AttributeEmptyParenthesesFixer;
use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\Basic\NoTrailingCommaInSinglelineFixer;
use PhpCsFixer\Fixer\Basic\OctalNotationFixer;
use PhpCsFixer\Fixer\Basic\PsrAutoloadingFixer;
use PhpCsFixer\Fixer\Basic\SingleLineEmptyBodyFixer;
use PhpCsFixer\Fixer\Casing\ClassReferenceNameCasingFixer;
use PhpCsFixer\Fixer\Casing\MagicConstantCasingFixer;
use PhpCsFixer\Fixer\Casing\MagicMethodCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeFunctionCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeTypeDeclarationCasingFixer;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\CastNotation\LowercaseCastFixer;
use PhpCsFixer\Fixer\CastNotation\ShortScalarCastFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer;
use PhpCsFixer\Fixer\ClassNotation\SingleTraitInsertPerStatementFixer;
use PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUnneededControlParenthesesFixer;
use PhpCsFixer\Fixer\ControlStructure\NoUselessElseFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchContinueToBreakFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use PhpCsFixer\Fixer\FunctionNotation\CombineNestedDirnameFixer;
use PhpCsFixer\Fixer\FunctionNotation\FopenFlagOrderFixer;
use PhpCsFixer\Fixer\FunctionNotation\FopenFlagsFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\FunctionNotation\ImplodeCallFixer;
use PhpCsFixer\Fixer\FunctionNotation\LambdaNotUsedImportFixer;
use PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoUnreachableDefaultArgumentValueFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoUselessSprintfFixer;
use PhpCsFixer\Fixer\FunctionNotation\NullableTypeDeclarationForDefaultNullValueFixer;
use PhpCsFixer\Fixer\FunctionNotation\PhpdocToParamTypeFixer;
use PhpCsFixer\Fixer\FunctionNotation\PhpdocToPropertyTypeFixer;
use PhpCsFixer\Fixer\FunctionNotation\PhpdocToReturnTypeFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\FunctionNotation\VoidReturnFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer;
use PhpCsFixer\Fixer\Import\NoUnneededImportAliasFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareEqualNormalizeFixer;
use PhpCsFixer\Fixer\LanguageConstruct\IsNullFixer;
use PhpCsFixer\Fixer\LanguageConstruct\NullableTypeDeclarationFixer;
use PhpCsFixer\Fixer\LanguageConstruct\SingleSpaceAroundConstructFixer;
use PhpCsFixer\Fixer\ListNotation\ListSyntaxFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLinesBeforeNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\CleanNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\NoLeadingNamespaceWhitespaceFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Operator\LongToShorthandOperatorFixer;
use PhpCsFixer\Fixer\Operator\NewWithParenthesesFixer;
use PhpCsFixer\Fixer\Operator\NoSpaceAroundDoubleColonFixer;
use PhpCsFixer\Fixer\Operator\ObjectOperatorWithoutWhitespaceFixer;
use PhpCsFixer\Fixer\Operator\StandardizeNotEqualsFixer;
use PhpCsFixer\Fixer\Operator\TernaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\TernaryToElvisOperatorFixer;
use PhpCsFixer\Fixer\Operator\TernaryToNullCoalescingFixer;
use PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Phpdoc\NoBlankLinesAfterPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAddMissingParamAnnotationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAlignFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocIndentFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoAccessFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoEmptyReturnFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocNoPackageFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocOrderByValueFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocReturnSelfReferenceFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocScalarFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSingleLineVarSpacingFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocToCommentFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTrimConsecutiveBlankLineSeparationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTrimFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocVarAnnotationCorrectOrderFixer;
use PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitConstructFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDedicateAssertFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitDedicateAssertInternalTypeFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitExpectationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitFqcnAnnotationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMockFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitMockShortWillReturnFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitNoExpectationAnnotationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitSetUpTearDownVisibilityFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestCaseStaticMethodCallsFixer;
use PhpCsFixer\Fixer\ReturnNotation\NoUselessReturnFixer;
use PhpCsFixer\Fixer\Semicolon\NoEmptyStatementFixer;
use PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\Semicolon\SpaceAfterSemicolonFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use PhpCsFixer\Fixer\Strict\StrictParamFixer;
use PhpCsFixer\Fixer\StringNotation\SimpleToComplexStringVariableFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use PhpCsFixer\Fixer\Whitespace\ArrayIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use PhpCsFixer\Fixer\Whitespace\CompactNullableTypeDeclarationFixer;
use PhpCsFixer\Fixer\Whitespace\HeredocIndentationFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
use PhpCsFixer\Fixer\Whitespace\NoWhitespaceInBlankLineFixer;
use PhpCsFixer\Fixer\Whitespace\TypeDeclarationSpacesFixer;
use PhpCsFixer\Fixer\Whitespace\TypesSpacesFixer;
use SlevomatCodingStandard\Sniffs\Attributes\DisallowAttributesJoiningSniff;
use SlevomatCodingStandard\Sniffs\Attributes\DisallowMultipleAttributesPerLineSniff;
use SlevomatCodingStandard\Sniffs\Classes\RequireConstructorPropertyPromotionSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireNullSafeObjectOperatorSniff;
use SlevomatCodingStandard\Sniffs\Exceptions\ReferenceThrowableOnlySniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ParameterTypeHintSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\PropertyTypeHintSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ReturnTypeHintSniff;
use Symplify\CodingStandard\Fixer\Commenting\ParamReturnAndVarTagMalformsFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPreparedSets(psr12: true)
    ->withRules(
        [
            // Function http_build_query() should always have specified `$arg_separator` parameter
            SpecifyArgSeparatorFixer::class,
            // Abstract class should have prefix "Abstract"
            AbstractClassNameSniff::class,
            // Classes should have suffix by theirs parent class/interface
            ClassNameSuffixByParentSniff::class,
            // Interface should have suffix "Interface"
            InterfaceNameSniff::class,
            // Trait should have suffix "Trait"
            TraitNameSniff::class,
            // Class and Interface names should be unique in a project, they should never be duplicated
            DuplicateClassNameSniff::class,
            // Control Structures must have at least one statement inside of the body (empty catch rules is skipped)
            EmptyStatementSniff::class,
            // For loops that have only a second expression (the condition) should be converted to while loops
            ForLoopShouldBeWhileLoopSniff::class,
            // Incrementers in nested loops should use different variable names
            JumbledIncrementerSniff::class,
            // If statements that are always evaluated should not be used
            UnconditionalIfStatementSniff::class,
            // Methods should not be declared final inside of classes that are declared final
            UnnecessaryFinalModifierSniff::class,
            // Methods should not be defined that only call the parent method
            UselessOverridingMethodSniff::class,
            // Doc comment formatting (but some of the rules are skipped)
            DocCommentSniff::class,
            // There should only be one class defined in a file
            OneClassPerFileSniff::class,
            // There should only be one interface defined in a file
            OneInterfacePerFileSniff::class,
            // There should only be one trait defined in a file
            OneTraitPerFileSniff::class,
            // Exactly one space is allowed after a cast
            SpaceAfterCastSniff::class,
            // When referencing arrays you should not put whitespace around the opening bracket or before the closing bracket
            ArrayBracketSpacingSniff::class,
            // Various array declaration rules (but some of the rules are skipped)
            ArrayDeclarationSniff::class,
            // The self keyword should be used instead of the current class name
            SelfMemberReferenceSniff::class,
            // The asterisks in a doc comment should align, and there should be one space between the asterisk and tags
            DocCommentAlignmentSniff::class,
            // Empty catch statements must have comment explaining why the exception is not handled
            EmptyCatchCommentSniff::class,
            // Tests that the ++ operators are used when possible and not used when it makes the code confusing
            IncrementDecrementUsageSniff::class,
            // Verifies that class members have scope modifiers
            MemberVarScopeSniff::class,
            // Detects merge conflict artifacts left in files
            GitMergeConflictSniff::class,
            // Casts should not have whitespace inside the parentheses
            CastSpacingSniff::class,
            // The php constructs like echo, return, include, etc. should have one space after them
            LanguageConstructSpacingSniff::class,
            // Verifies that operators have valid spacing surrounding them
            LogicalOperatorSpacingSniff::class,
            // The php keywords static, public, private, and protected should have one space after them
            ScopeKeywordSpacingSniff::class,
            // Semicolons should not have spaces before them
            SemicolonSpacingSniff::class,
            // Converts simple usages of `array_push($x, $y,` to `$x[] = $y;`.
            ArrayPushFixer::class,
            // Replace non multibyte-safe functions with corresponding mb function
            MbStrFunctionsFixer::class,
            // Replaces `rand`, `srand`, `getrandmax` functions calls with their `mt_*` analogs
            RandomApiMigrationFixer::class,
            // Cast shall be used, not `settype()`
            SetTypeToCastFixer::class,
            // Attributes declared without arguments must not be followed by empty parentheses.
            AttributeEmptyParenthesesFixer::class,
            // Array index should always be written by using square braces
            NormalizeIndexBraceFixer::class,
            // Empty body of class, interface, trait, enum or function must be abbreviated as {} and placed on the same line as the previous symbol, separated by a single space.
            SingleLineEmptyBodyFixer::class, // Defined in PER 2.0
            // Values separated by a comma on a single line should not have a trailing comma.
            NoTrailingCommaInSinglelineFixer::class,
            // Literal octal must be in 0o notation.
            OctalNotationFixer::class,
            // Arrays should be formatted like function/method arguments
            TrimArraySpacesFixer::class,
            // In array declaration, there MUST be a whitespace after each comma
            WhitespaceAfterCommaInArrayFixer::class,
            // Classes must be in a path that matches their namespace
            PsrAutoloadingFixer::class,
            // When referencing an internal class it must be written using the correct casing.
            ClassReferenceNameCasingFixer::class,
            // Magic constants should be referred to using the correct casing.
            MagicConstantCasingFixer::class,
            // Magic method definitions and calls must be using the correct casing
            MagicMethodCasingFixer::class,
            // Function defined by PHP should be called using the correct casing
            NativeFunctionCasingFixer::class,
            // Native type hints for functions should use the correct case
            NativeTypeDeclarationCasingFixer::class,
            // A single space or none should be between cast and variable
            CastSpacesFixer::class,
            // Cast should be written in lower case
            LowercaseCastFixer::class,
            // Cast like `(boolean)` and `(integer)` should be written as `(bool)`, `(int)` etc.
            ShortScalarCastFixer::class,
            // There should be no empty lines after class opening brace
            NoBlankLinesAfterClassOpeningFixer::class,
            // Inside class or interface element `self` should be preferred to the class name itself
            SelfAccessorFixer::class,
            // Each trait `use` must be done as single statement
            SingleTraitInsertPerStatementFixer::class,
            // There should not be any empty comments
            NoEmptyCommentFixer::class,
            // There should not be useless `else` cases
            NoUselessElseFixer::class,
            // Switch case must not be ended with `continue` but with `break`.
            SwitchContinueToBreakFixer::class,
            // Replace multiple nested calls of `dirname` by only one call with second `$level` parameter.
            CombineNestedDirnameFixer::class,
            // Order the flags in `fopen` calls, `b` and `t` must be last.
            FopenFlagOrderFixer::class,
            // The flags in `fopen` calls must contain `b` and must omit `t`.
            FopenFlagsFixer::class,
            // Add missing space between function's argument and its typehint.
            TypeDeclarationSpacesFixer::class,
            // None space should be around union type and intersection type operators.
            TypesSpacesFixer::class,
            // Function `implode` must be called with 2 arguments in the documented order.
            ImplodeCallFixer::class,
            // Lambda must not import variables it doesn't use.
            LambdaNotUsedImportFixer::class,
            // In function arguments there must not be arguments with default values before non-default ones.
            NoUnreachableDefaultArgumentValueFixer::class,
            // There must be no `sprintf` calls with only the first argument.
            NoUselessSprintfFixer::class,
            // Add `?` before single type declarations when parameters have a default null value.
            NullableTypeDeclarationForDefaultNullValueFixer::class,
            // There must not be a space before colon in return type declarations.
            ReturnTypeDeclarationFixer::class,
            // Add `void` return type to functions with missing or empty return statements.
            VoidReturnFixer::class,
            // Remove leading slashes in `use` clauses.
            NoLeadingImportSlashFixer::class,
            // Imports should not be aliased as the same name.
            NoUnneededImportAliasFixer::class,
            // Unused `use` statements must be removed.
            NoUnusedImportsFixer::class,
            // Order `use` statements.
            OrderedImportsFixer::class,
            // Equal sign in declare statement should not be surrounded by spaces.
            DeclareEqualNormalizeFixer::class,
            // Replaces `is_null($var)` expression with `null === $var`
            IsNullFixer::class,
            // Nullable single type declaration should be standardised using question mark syntax.
            NullableTypeDeclarationFixer::class,
            // Ensures a single space around language constructs.
            SingleSpaceAroundConstructFixer::class,
            // Namespace must not contain spacing, comments or PHPDoc.
            CleanNamespaceFixer::class,
            // The namespace declaration line shouldn't contain leading whitespace.
            NoLeadingNamespaceWhitespaceFixer::class,
            // Binary operators should be surrounded by exactly one single space.
            BinaryOperatorSpacesFixer::class,
            // Shorthand notation for operators should be used if possible.
            LongToShorthandOperatorFixer::class,
            // There must be no space around scope resolution double colons
            NoSpaceAroundDoubleColonFixer::class,
            // All instances created with new keyword must be followed by parentheses.
            NewWithParenthesesFixer::class,
            // There should not be space before or after object operators `->` and `?->`.
            ObjectOperatorWithoutWhitespaceFixer::class,
            // Replace all `<>` with `!=`.
            StandardizeNotEqualsFixer::class,
            // Standardize spaces around ternary operator.
            TernaryOperatorSpacesFixer::class,
            // Use the Elvis operator `?:` where possible.
            TernaryToElvisOperatorFixer::class,
            // Use `null` coalescing operator `??` where possible.
            TernaryToNullCoalescingFixer::class,
            // Unary operators should be placed adjacent (without a space) to their operands.
            UnaryOperatorSpacesFixer::class,
            // There should not be blank lines between docblock and the documented element.
            NoBlankLinesAfterPhpdocFixer::class,
            // There should not be empty PHPDoc blocks.
            NoEmptyPhpdocFixer::class,
            // PHPDoc should contain `@param` for all params.
            PhpdocAddMissingParamAnnotationFixer::class,
            // Docblocks should have the same indentation as the documented subject.
            PhpdocIndentFixer::class,
            // `@access` annotations should be omitted from PHPDoc.
            PhpdocNoAccessFixer::class,
            // `@return void` and `@return null` annotations should be omitted from PHPDoc.
            PhpdocNoEmptyReturnFixer::class,
            // `@package` and `@subpackage` annotations should be omitted from PHPDoc.
            PhpdocNoPackageFixer::class,
            // The type of `@return` annotations of methods returning a reference to itself must the configured one.
            PhpdocReturnSelfReferenceFixer::class,
            // Scalar types should always be written in the same form.
            PhpdocScalarFixer::class,
            // Single line `@var` PHPDoc should have proper spacing.
            PhpdocSingleLineVarSpacingFixer::class,
            // Removes extra blank lines after summary and after description in PHPDoc.
            PhpdocTrimConsecutiveBlankLineSeparationFixer::class,
            // PHPDoc should start and end with content
            PhpdocTrimFixer::class,
            // Docblocks should only be used on structural elements.
            PhpdocToCommentFixer::class,
            // The correct case must be used for standard PHP types in PHPDoc.
            PhpdocTypesFixer::class,
            // `@var` and `@type` annotations must have type and name in the correct order
            PhpdocVarAnnotationCorrectOrderFixer::class,
            // PHP code must use the long `<?php` tags or short-echo `<?=` tags and not other tag variations
            FullOpeningTagFixer::class,
            // PHPUnit assertion method calls like ->assertSame(true, $foo) should be written with dedicated method like ->assertTrue($foo)
            PhpUnitConstructFixer::class,
            // PHPUnit assertions like assertInternalType, assertFileExists, should be used over assertTrue
            PhpUnitDedicateAssertFixer::class,
            // PHPUnit assertions like assertIsArray should be used over assertInternalType
            PhpUnitDedicateAssertInternalTypeFixer::class,
            // Use dedicated helper methods createMock() and createPartialMock() where possible
            PhpUnitMockFixer::class,
            // Use of eg. ->will($this->returnValue(..)) must be replaced by its shorter equivalent such as ->willReturn(...)
            PhpUnitMockShortWillReturnFixer::class,
            // Use expectedException*() methods instead of @expectedException* annotation (both following fixers must be applied to do so)
            PhpUnitNoExpectationAnnotationFixer::class,
            // Usages of ->setExpectedException* methods MUST be replaced by ->expectException* methods
            PhpUnitExpectationFixer::class,
            // PHPUnit annotations should be a FQCNs including a root namespace.
            PhpUnitFqcnAnnotationFixer::class,
            // Visibility of setUp() and tearDown() method should be kept protected
            PhpUnitSetUpTearDownVisibilityFixer::class,
            // There should not be an empty `return` statement at the end of a function
            NoUselessReturnFixer::class,
            // Remove useless (semicolon) statements
            NoEmptyStatementFixer::class,
            // Single-line whitespace before closing semicolon are prohibited
            NoSinglelineWhitespaceBeforeSemicolonsFixer::class,
            // Fix whitespace after a semicolon
            SpaceAfterSemicolonFixer::class,
            // Force strict types declaration in all files
            DeclareStrictTypesFixer::class,
            // Functions should be used with `$strict` param set to `true`
            StrictParamFixer::class,
            // Comparisons should be strict, `===` or `!==` must be used for comparisons
            StrictComparisonFixer::class,
            // Converts explicit variables in double-quoted strings from simple to complex format (${ to {$).
            SimpleToComplexStringVariableFixer::class,
            // Convert double quotes to single quotes for simple strings
            SingleQuoteFixer::class,
            // Each element of an array must be indented exactly once.
            ArrayIndentationFixer::class,
            // Remove extra spaces in a nullable typehint
            CompactNullableTypeDeclarationFixer::class,
            // Heredoc/nowdoc content must be properly indented.
            HeredocIndentationFixer::class,
            // Remove trailing whitespace at the end of blank lines
            NoWhitespaceInBlankLineFixer::class,
            // Use \Throwable instead of \Exception
            ReferenceThrowableOnlySniff::class,
            // The @param, @return, @var and inline @var annotations should keep standard format
            ParamReturnAndVarTagMalformsFixer::class,
            // Takes `@var` annotation of non-mixed types and adjusts accordingly the property signature to a native PHP 7.4+ type-hint.
            PhpdocToPropertyTypeFixer::class,
            PropertyTypeHintSniff::class,
            // Takes `@param` annotations of non-mixed types and adjusts accordingly the function signature to a native type-hints.
            PhpdocToParamTypeFixer::class,
            ParameterTypeHintSniff::class,
            // Takes `@return` annotation of non-mixed types and adjusts accordingly the function signature.
            PhpdocToReturnTypeFixer::class,
            ReturnTypeHintSniff::class,
            // Requires that only one attribute can be placed inside #[].
            DisallowAttributesJoiningSniff::class,
            // Disallows multiple attributes of some target on same line.
            DisallowMultipleAttributesPerLineSniff::class,
            // Promote constructor properties
            // For php-cs-fixer implementation @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/5956
            RequireConstructorPropertyPromotionSniff::class,
            // Use `null-safe` operator `?->` where possible
            RequireNullSafeObjectOperatorSniff::class,
        ],
    )
    // Line length should not exceed 120 characters
    ->withConfiguredRule(LineLengthSniff::class, ['absoluteLineLimit' => 0, 'lineLimit' => 120])
    ->withConfiguredRule(ForbiddenFunctionsSniff::class, [
        'forbiddenFunctions' => [
            // Program execution functions, inspired by https://github.com/spaze/phpstan-disallowed-calls
            'exec' => null,
            'passthru' => null,
            'proc_open' => null,
            'shell_exec' => null,
            'system' => null,
            'pcntl_exec' => null,
            'popen' => null,

            // Dangerous function calls, inspired by https://github.com/spaze/phpstan-disallowed-calls
            'apache_setenv' => null, // might overwrite existing variables
            'dl' => null, // removed from most SAPIs, might load untrusted code
            'eval' => null, // eval is evil, please write more code and do not use eval()
            'extract' => null, // do not use extract() and especially not on untrusted data
            'highlight_file' => null, // might reveal source code or config files
            'pfsockopen' => null, // use fsockopen() to create non-persistent socket connections
            'posix_getpwuid' => null, // might reveal system user information
            'posix_kill' => null, // do not send signals to processes from the script
            'posix_mkfifo' => null, // do not create named pipes in the script
            'posix_mknod' => null, // do not create special files in the script
            'proc_nice' => null, // changes the priority of the current process
            'putenv' => null, // might overwrite existing variables
            'show_source' => null, // might reveal source code or config files (alias of highlight_file())
            'socket_create_listen' => null, // do not accept new socket connections in the PHP script
            'socket_listen' => null, // do not accept new socket connections in the PHP script

            // PHP include/require functions, use autoloading instead
            'include' => null,
            'include_once' => null,
            'require' => null,
            'require_once' => null,

            // Probably forgotten debug calls, use logger instead
            'dump' => null,
            'echo' => null,
            'phpinfo' => null,
            'print_r' => null,
            'printf' => null,
            'var_export' => null,
            'var_dump' => null,
        ],
    ])
    // Master functions shall be used instead of aliases
    ->withConfiguredRule(NoAliasFunctionsFixer::class, ['sets' => ['@all']])
    // There should be exactly one blank line before a namespace declaration.
    ->withConfiguredRule(BlankLinesBeforeNamespaceFixer::class, ['min_line_breaks' => 2, 'max_line_breaks' => 2])
    // Proper operator spacing
    ->withConfiguredRule(OperatorSpacingSniff::class, ['ignoreNewlines' => true])
    // PHP arrays should be declared using the configured syntax
    ->withConfiguredRule(ArraySyntaxFixer::class, ['syntax' => 'short'])
    // The body of each structure MUST be enclosed by braces. Braces should be properly placed
    // @TODO move configuration to BracesPositionFixer after BracesFixer is not included in PSR-12 check anymore
    ->withConfiguredRule(
        BracesFixer::class,
        ['allow_single_line_closure' => true, 'allow_single_line_anonymous_class_with_empty_body' => true],
    )
    // Class, trait and interface elements must be separated with one or none blank line
    ->withConfiguredRule(ClassAttributesSeparationFixer::class, ['elements' => ['method' => 'one']])
    // Visibility MUST be declared on all properties, methods and class constants
    ->withConfiguredRule(VisibilityRequiredFixer::class, ['elements' => ['const', 'method', 'property']])
    // Conditions must be written in non-Yoda style
    ->withConfiguredRule(YodaStyleFixer::class, ['equal' => false, 'identical' => false, 'less_and_greater' => false])
    ->withConfiguredRule(ListSyntaxFixer::class, ['syntax' => 'short'])
    ->withConfiguredRule(ConcatSpaceFixer::class, ['spacing' => 'one'])
    // Removes `@param` and `@return` tags that don't provide any useful information
    ->withConfiguredRule(NoSuperfluousPhpdocTagsFixer::class, [
        'allow_unused_params' => false, // whether param annotation without actual signature is allowed
        'remove_inheritdoc' => true, // remove @inheritDoc tags
    ])
    // All items of the given PHPDoc tags must be left-aligned.
    // @TODO: Re-enable if https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/issues/8052 is fixed
    //->withConfiguredRule(PhpdocAlignFixer::class, ['align' => 'left'])
    // Annotations in PHPDoc should be ordered in defined sequence.
    ->withConfiguredRule(PhpdocOrderFixer::class, ['order' => ['param', 'return', 'throws']])
    // Order phpdoc tags by value.
    ->withConfiguredRule(PhpdocOrderByValueFixer::class, ['annotations' => ['covers', 'group', 'throws']])
    // Enforce camel case for PHPUnit test methods.
    ->withConfiguredRule(PhpUnitMethodCasingFixer::class, ['case' => 'camel_case'])
    // Calls to `PHPUnit\Framework\TestCase` static methods must all be of the same type (`$this->...`)
    ->withConfiguredRule(PhpUnitTestCaseStaticMethodCallsFixer::class, ['call_type' => 'this'])
    // An empty line feed must precede any configured statement
    ->withConfiguredRule(BlankLineBeforeStatementFixer::class, ['statements' => ['return', 'try']])
    // Removes extra blank lines and/or blank lines following configuration
    ->withConfiguredRule(NoExtraBlankLinesFixer::class, [
        'tokens' => [
            'attribute',
            'case',
            'continue',
            'curly_brace_block',
            'default',
            'extra',
            'parenthesis_brace_block',
            'square_brace_block',
            'switch',
            'throw',
            'use',
            'use_trait',
        ],
    ])
    // Elements of classes/interfaces/traits/enums should be in the defined order
    ->withConfiguredRule(
        OrderedClassElementsFixer::class,
        [
            'order' => [
                'use_trait',
                'case', // enum values should be before other elements
                'constant',
                'property',
                'construct',
                'destruct',
                'magic',
                'phpunit', // phpunit special methods like setUp should be before test methods
                'method',
            ],
        ],
    )
    // Spaces should be properly placed in a function declaration.
    ->withConfiguredRule(
        FunctionDeclarationFixer::class,
        ['closure_fn_spacing' => 'none'], // Defined in PER 2.0
    )
    // Removes unneeded parentheses around specified control statements.
    ->withConfiguredRule(
        NoUnneededControlParenthesesFixer::class,
        ['statements' => ['break', 'clone', 'continue', 'echo_print', 'others', 'switch_case', 'yield', 'yield_from']],
    )
    // Multi-line arrays, arguments list and parameters list must have a trailing comma
    ->withConfiguredRule(
        TrailingCommaInMultilineFixer::class,
        ['after_heredoc' => true, 'elements' => ['arguments', 'arrays', 'match', 'parameters']], // Defined in PER 2.0
    )
    // Removes the leading part of FQCN
    ->withConfiguredRule(
        FullyQualifiedStrictTypesFixer::class,
        ['import_symbols' => true], // Also import symbols from other namespaces than in current file
    )
    // Spaces and newlines in method arguments and attributes
    ->withConfiguredRule(
        MethodArgumentSpaceFixer::class,
        ['attribute_placement' => 'standalone', 'on_multiline' => 'ensure_fully_multiline'],
    )
    ->withSkip([
        // We allow empty catch statements (but they must have comment - see EmptyCatchCommentSniff)
        EmptyStatementSniff::class . '.DetectedCatch' => null,

        // Skip because of its attempts to add spaces in declare(strict_types=1); starting with ECS 12.2.0
        // @TODO: In future ECS versions try whether its is still broken or this skip could be removed
        OperatorSpacingSniff::class . '.NoSpaceAfter' => null,
        OperatorSpacingSniff::class . '.NoSpaceBefore' => null,

        // Skip unwanted rules from DocCommentSniff
        DocCommentSniff::class . '.ContentAfterOpen' => null,
        DocCommentSniff::class . '.ContentBeforeClose' => null,
        DocCommentSniff::class . '.MissingShort' => null,
        DocCommentSniff::class . '.NonParamGroup' => null,
        DocCommentSniff::class . '.ParamGroup' => null,
        DocCommentSniff::class . '.ParamNotFirst' => null,
        DocCommentSniff::class . '.SpacingBeforeTags' => null,
        DocCommentSniff::class . '.TagValueIndent' => null,

        // Skip unwanted rules from ArrayDeclarationSniff
        ArrayDeclarationSniff::class . '.CloseBraceNotAligned' => null,
        ArrayDeclarationSniff::class . '.DoubleArrowNotAligned' => null,
        ArrayDeclarationSniff::class . '.KeyNotAligned' => null,
        ArrayDeclarationSniff::class . '.MultiLineNotAllowed' => null,
        ArrayDeclarationSniff::class . '.SingleLineNotAllowed' => null,
        ArrayDeclarationSniff::class . '.ValueNoNewline' => null,
        ArrayDeclarationSniff::class . '.ValueNotAligned' => null,

        // There could be more than one space after star (eg. in Doctrine annotations)
        DocCommentAlignmentSniff::class . '.SpaceAfterStar' => null,

        // Allow single line closures
        ScopeClosingBraceSniff::class . '.ContentBefore' => null,

        // Skip unwanted rules from PropertyTypeHintSniff
        PropertyTypeHintSniff::class . '.' . PropertyTypeHintSniff::CODE_MISSING_TRAVERSABLE_TYPE_HINT_SPECIFICATION => null,
        PropertyTypeHintSniff::class . '.' . PropertyTypeHintSniff::CODE_MISSING_ANY_TYPE_HINT => null,

        // Skip unwanted rules from ParameterTypeHintSniff
        ParameterTypeHintSniff::class . '.' . ParameterTypeHintSniff::CODE_MISSING_TRAVERSABLE_TYPE_HINT_SPECIFICATION => null,
        ParameterTypeHintSniff::class . '.' . ParameterTypeHintSniff::CODE_MISSING_ANY_TYPE_HINT => null,

        // Skip unwanted rules from ReturnTypeHintSniff
        ReturnTypeHintSniff::class . '.' . ReturnTypeHintSniff::CODE_MISSING_TRAVERSABLE_TYPE_HINT_SPECIFICATION => null,
        ReturnTypeHintSniff::class . '.' . ReturnTypeHintSniff::CODE_MISSING_ANY_TYPE_HINT => null,
    ]);
