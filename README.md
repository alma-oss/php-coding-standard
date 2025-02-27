# Alma Career Coding Standard for PHP

[![Latest Stable Version](https://img.shields.io/packagist/v/lmc/coding-standard.svg?style=flat-square)](https://packagist.org/packages/lmc/coding-standard)

PHP coding standard used in [Alma Career][Alma Career] (formerly LMC) products.

The standard is based on [PSR-12][psr-12] and partially [PER 2.0][per-2] and adds
various checks to make sure the code is readable, follows the same conventions, and does not contain common mistakes.

We use [EasyCodingStandard][ecs] to define and execute checks created for both [PHP-CS-Fixer] and [PHP_CodeSniffer].

## Installation

```bash
composer require --dev lmc/coding-standard
```

## Usage

1. Create `ecs.php` file in the root directory of your project and import the code-style rules:

```php
<?php declare(strict_types=1);

use Lmc\CodingStandard\Set\SetList;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPaths([__DIR__ . '/src', __DIR__ . '/tests']) // optionally add 'config' or other directories with PHP files
    ->withRootFiles() // to also check ecs.php and all other php files in the root directory
    ->withSets(
        [
            SetList::ALMACAREER,
        ]
    );
```

2. Run the check command

```bash
vendor/bin/ecs check
```

3. Optionally we recommend adding this to `scripts` section of your `composer.json`:

```json
    "scripts": {
        "analyze": [
            "vendor/bin/ecs check --ansi",
            "[... other scripts, like PHPStan etc.]"
        ],
        "fix": [
            "...",
            "vendor/bin/ecs check --ansi --fix"
        ],
    }
```

Now you will be able to run the fix using `composer analyze` and execute automatic fixes with `composer fix`.

### Add custom checks or override default settings

On top of the default code-style rules, you are free to add any rules from [PHP-CS-Fixer] or [PHP_CodeSniffer].
If needed, you can also override any default settings.

Below find examples of some more opinionated checks you may want to add depending on your needs:

```php
<?php declare(strict_types=1);

use Lmc\CodingStandard\Set\SetList;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestAnnotationFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    /* (...) */
    ->withSets(
        [
            SetList::ALMACAREER,
        ]
    )
    ->withRules(
        [
            // PHPUnit attributes must be used over their respective PHPDoc-based annotations. (Use with PHPUnit 10+.)
            PhpUnitAttributesFixer::class,
            // Single-line comments must have proper spacing (one space after `//`).
            SingleLineCommentSpacingFixer::class,
            // Convert multiline string to heredoc or nowdoc.
            MultilineStringToHeredocFixer::class,
        ]
    )
    // Enforce line-length to 120 characters.
    ->withConfiguredRule(LineLengthSniff::class, ['absoluteLineLimit' => 120])
    // Tests must have @test annotation.
    ->withConfiguredRule(PhpUnitTestAnnotationFixer::class, ['style' => 'annotation'])
    // Specify elements separation.
    ->withConfiguredRule(ClassAttributesSeparationFixer::class, ['elements' => ['const' => 'none', 'method' => 'one', 'property' => 'none']])
    /* (...) */
```

See [EasyCodingStandard docs][ecs-docs] for more configuration options.


### Exclude (skip) checks or files

You can configure your `ecs.php` file to entirely skip some files, disable specific checks, or suppress specific errors.

```php
<?php declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Arrays\ArrayDeclarationSniff;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    /* (...) */
    ->withSkip(
        [
            // Ignore specific check only in specific files
            ForbiddenFunctionsSniff::class => [__DIR__ . '/src-tests/bootstrap.php'],
            // Disable check entirely
            ArrayDeclarationSniff::class,
            // Skip one file
            __DIR__ . '/file/to/be/skipped.php',
            // Skip entire directory
            __DIR__ . '/ignored/directory/*',
        ]
    )
    /* (...) */
```

See [EasyCodingStandard docs][ecs-docs] for more configuration options.

### IDE integration

For integration with PHPStorm and other IDEs, follow instructions in [EasyCodingStandard README][ecs-readme-ide].

## Changelog
For the latest changes, see [CHANGELOG.md](CHANGELOG.md) file. This library follows [Semantic Versioning](https://semver.org/).

## License
This library is open-source software licensed under the [MIT license](LICENSE.md).

[Alma Career]: https://www.almacareer.com/
[PHP-CS-Fixer]: https://github.com/FriendsOfPHP/PHP-CS-Fixer
[PHP_CodeSniffer]: https://github.com/squizlabs/PHP_CodeSniffer
[psr-12]: https://www.php-fig.org/psr/psr-12/
[per-2]: https://www.php-fig.org/per/coding-style/
[ecs]: https://github.com/easy-coding-standard/easy-coding-standard
[ecs-docs]: https://github.com/easy-coding-standard/easy-coding-standard#configure
[ecs-readme-ide]: https://github.com/easy-coding-standard/easy-coding-standard/blob/9.0.0/README.md#your-ide-integration
