# Changelog

<!-- We follow Semantic Versioning (https://semver.org/) and Keep a Changelog principles (https://keepachangelog.com/) -->

<!-- There is always Unreleased section on the top. Subsections (Added, Changed, Fixed, Removed) should be added as needed. -->

## Unreleased
- Remove skip of BlankLineAfterOpeningTagFixer to be PSR-12 compliant.

## 4.2.0 - 2025-02-28
- Rename the package from "Alma Career Czechia Standard for PHP" to more broad "Alma Career Coding Standard for PHP". 🎉
- Change composer package name to `almacareer/coding-standard`. Previous `lmc/coding-standard` is now deprecated.
- Move GitHub repository from `lmc-eu/php-coding-standard` to `alma-oss/php-coding-standard`.
- Update PHP CS Fixer to fixed version.
- Add `SetList::ALMACAREER` for easier importing of the coding standard.

## 4.1.2 - 2024-12-27
- Restrict php-cs-fixer version 3.65.0 (included in ECS version 12.4+) from being installed because of [bug in `NullableTypeDeclarationFixer`](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer/issues/8330).

## 4.1.1 - 2024-06-10
- Disable incorrectly behaving PhpdocAlignFixer.

## 4.1.0 - 2024-05-27
- Add most of the available checks for [PER-2](https://www.php-fig.org/per/coding-style/) coding style.
- Add many new checks from `php-cs-fixer` up to version 3.56.
- Add available php-cs-fixer rules for PHP 8.1 and 8.2 (which are automatically run only on compatible PHP versions).

## 4.0.0 - 2024-05-27
- BC: Update to symplify/easy-coding-standard ^12.1 and change configuration format in `ecs.php`. See [UPGRADE-4.0.md](UPGRADE-4.0.md) for step-by-step upgrade howto.
- BC: Move coding standard declarations from `ecs-7.4.php`, `ecs-8.0.php` and `ecs-8.1.php` to `ecs.php` and remove the former files.
- BC: Change base coding standard from [PSR-2](https://www.php-fig.org/psr/psr-2/) to [PSR-12](https://www.php-fig.org/psr/psr-12/).
- BC: Change deprecated `php-cs-fixer` sniffs to new ones.
- Rebrand to Alma Career in documentation and meta information.
- Require PHP ^8.0.
- Update to slevomat/coding-standard ^8.0.
- Update to squizlabs/php_codesniffer ^3.9.
- Refactor: Remove nette/utils dependency.
- Add tests to ensure the code style defined by this library is being properly checked and fixed.

## 3.3.1 - 2022-05-23
- Lock `symplify/easy-coding-standard` to <10.2.4 because of backward incompatibilities introduced in its bugfix releases.

## 3.3.0 - 2022-04-21
- Update to symplify/easy-coding-standard ^10.0
- Allow `slevomat/coding-standard` ^7
- Add new `ecs-8.0.php` coding standard declaration file for PHP 8.0+.
- Add new `ecs-8.1.php` coding standard declaration file for PHP 8.1+.

## 3.2.1 - 2022-01-04
- Fix SpecifyArgSeparatorFixer type error when adding empty `$numeric_prefix` parameter in PHP 7.4+.

## 3.2.0 - 2021-05-20
- Fix SpecifyArgSeparatorFixer not compatible with php-cs-fixer 3.0.
- Add new `ecs-7.4.php` coding standard declaration file for PHP 7.4+.

## 3.1.0 - 2021-05-13
- Use php-cs-fixer 3.0.
- Use new prefixed version of symplify/easy-coding-standard.

## 3.0.1 - 2021-04-21
- `PhpUnitExpectationFixer` is now used only on PHP 8.0+. See [symplify#3130](https://github.com/symplify/symplify/issues/3130).

## 3.0.0 - 2021-03-02
- **[BC break]** Change YAML config to PHP. See [UPGRADE-3.0.md](UPGRADE-3.0.md) for step-by-step upgrade howto.
- Replace `Symplify\CodingStandard\Sniffs\Naming\[AbstractClassNameSniff, ClassNameSuffixByParentSniff, InterfaceNameSniff and TraitNameSniff]` with equivalent versions backported to this repository.
- Drop PHP 7.2 support.
- Upgrade to easy-coding-standard 9.
- Add new fixers from PHP-CS-Fixer 2.17:
    - `ArrayPushFixer` - Converts simple usages of `array_push($x, $y);` to `$x[] = $y;`.
    - `SwitchContinueToBreakFixer` - Switch case must not be ended with `continue` but with `break`.
    - `LambdaNotUsedImportFixer` - Lambda must not import variables it doesn't use.
    - `NoUselessSprintfFixer` - There must be no `sprintf` calls with only the first argument.
    - `SingleSpaceAfterConstructFixer` - Ensures a single space after language constructs.
    - `CleanNamespaceFixer` - Namespace must not contain spacing, comments or PHPDoc.
    - `TernaryToElvisOperatorFixer` - Use the Elvis operator `?:` where possible.
    - `PhpdocOrderByValueFixer`  Order phpdoc tags by value (order by default contents of 'covers', 'group' and 'throws').
    - `HeredocIndentationFixer` - Heredoc/nowdoc content must be properly indented.
- Add new PHP_CodeSniffer sniffs:
    - `GitMergeConflictSniff` - Detects merge conflict artifacts left in files.

## 2.1.0 - 2020-11-25
- Add various dangerous function calls to list of forbidden functions.

## 2.0.4 - 2020-09-23
- Fix an improper fix of PSR-2 checks made in 2.0.3 to really make them being used again.

## 2.0.3 - 2020-05-04
- Fix PSR-2 checks to be used again (they were unintentionally not loaded since coding-standard version 2.0.0).
- Lock dependency of `symplify/coding-standard` to <7.2.20 to avoid deprecation errors.

## 2.0.2 - 2020-04-23
- Increase required version of symplify/easy-coding-standard to ^7.2.3.

## 2.0.1 - 2020-04-23
- Temporarily disable `ArrayDeclarationSniff.ValueNoNewline` because of [bug](https://github.com/squizlabs/PHP_CodeSniffer/issues/2937) in PHP_CodeSniffer 3.5.5.

## 2.0.0 - 2020-03-02
- BC: change the way the standard is imported to your `easy-coding-standard.yaml` (change `%vendor_dir%` placeholder directly to name of the vendor directory like `vendor`). See example in [README](https://github.com/alma-oss/php-coding-standard#usage).
- Drop PHP 7.1 support.
- Require EasyCodingStandard 7+.
- `VisibilityRequiredFixer` now check visibility is declared also on class constants.
- Add `Symplify\ParamReturnAndVarTagMalformsFixer` - the `@param`, `@return` and `@var` annotations should keep standard format.
- Add new fixers from PHP-CS-Fixer 2.15 and 2.16:
    - `NativeFunctionTypeDeclarationCasingFixer` - native type hints for functions should use the correct case.
    - `SingleTraitInsertPerStatementFixer` - each trait `use` must be done as single statement.
    - `PhpUnitDedicateAssertInternalTypeFixer` - PHPUnit assertions like `assertIsArray()` should be used over `assertInternalType()` (PHPUnit 7.5+ required).
    - `PhpUnitMockShortWillReturnFixer` - Use of eg. `->will($this->returnValue(..))` must be replaced by its shorter equivalent such as `->willReturn(...)`.
- `NoSuperfluousPhpdocTagsFixer` now also removes superfluous `@inheritdoc` tags.

## 1.3.0 - 2019-01-23
- Require EasyCodingStandard 5+.
- Add new fixers from PHP-CS-Fixer 2.14 and 2.13:
    - `CombineNestedDirnameFixer` - replace multiple nested calls of `dirname` by only one call with second `$level` parameter.
    - `FopenFlagOrderFixer` - order the flags in `fopen` calls, `b` and `t` must be last.
    - `FopenFlagsFixer` - the flags in `fopen` calls must contain `b` and must omit `t`.
    - `ImplodeCallFixer` - function `implode` must be called with 2 arguments in the documented order.
    - `PhpdocVarAnnotationCorrectOrderFixer` - `@var` and `@type` annotations must have type and name in the correct order
- Keep `@mixed` annotations preserved when explicitly declared.

## 1.2.0 - 2018-09-20
- Replace deprecated `Symplify\CodingStandard\Fixer\Naming\MagicMethodsNamingFixer` with `PhpCsFixer\Fixer\Casing\MagicMethodCasingFixer`.
- Add new fixers:
    - `NoSuperfluousPhpdocTagsFixer` to remove unnecessary `@return` and `@param` PHPDocs.
    - `PhpUnitTestCaseStaticMethodCallsFixer` to unify how assertion methods in PHPUnit tests are called.
    - `SetTypeToCastFixer` to ensure casting is used instead of `settype()` .

## 1.1.2 - 2018-07-19
- Change deprecated implementation of `Symplify\CodingStandard\Fixer\Naming\ClassNameSuffixByParentFixer` to `Symplify\CodingStandard\Sniffs\Naming\ClassNameSuffixByParentSniff`

## 1.1.1 - 2018-06-07
- Fix `Generic.Commenting.DocComment.SpacingBeforeTags` being reported on one-line phpDoc annotations (when PHP_Codesniffer 3.3.0+ is used).

## 1.1.0 - 2018-05-14
- Add `SpecifyArgSeparatorFixer` to make sure arg_separator is always defined when using `http_build_query()` function.
- Add PHPUnit fixers:
    - `PhpUnitMockFixer`: Ensure dedicated helper methods `createMock()` and `createPartialMock()` are used where possible instead of `->getMock()`.
    - `PhpUnitNoExpectationAnnotationFixer`: Use `setExpectedException()` instead of `@expectedException` annotation.
    - `PhpUnitSetUpTearDownVisibilityFixer`: Visibility of `setUp()` and `tearDown()` method should be kept protected as defined in PHPUnit TestCase.
- Do not check for `EventSubscriber` class suffixes via `ClassNameSuffixByParentFixer`.

## 1.0.1 - 2018-04-09
- Replace deprecated `ExceptionNameFixer` with more generic `ClassNameSuffixByParentFixer`.

## 1.0.0 - 2018-04-03
- Initial version
