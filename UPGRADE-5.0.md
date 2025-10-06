# Upgrading from 4.x to 5.0

### 1. Update dependency in composer.json
In the `require-dev` section of `composer.json` change the version constraint:

```diff
-        "almacareer/coding-standard": "^4.2",
+        "almacareer/coding-standard": "^5.0",
```

Then run `composer update almacareer/coding-standard`.

### 2. Update namespace imports

**[BC break]** The namespace has been changed from `Lmc\CodingStandard` to `AlmaOss\CodingStandard`.

Update your `ecs.php` file to use the new namespace:

```diff
<?php

declare(strict_types=1);

-use Lmc\CodingStandard\Set\SetList;
+use AlmaOss\CodingStandard\Set\SetList;
 use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withSets(
        [
            SetList::ALMACAREER,
        ]
    );
```

If you are using any custom sniffs or fixers from this package in your configuration, update their namespace as well:

```diff
-use Lmc\CodingStandard\Fixer\SpecifyArgSeparatorFixer;
+use AlmaOss\CodingStandard\Fixer\SpecifyArgSeparatorFixer;

-use Lmc\CodingStandard\Sniffs\Naming\ClassNameSuffixByParentSniff;
+use AlmaOss\CodingStandard\Sniffs\Naming\ClassNameSuffixByParentSniff;
```

### 3. PSR-12 compliance change

**[BC break]** The `BlankLineAfterOpeningTagFixer` is no longer skipped. This means that a blank line after the opening PHP tag (`<?php`) is now required to be PSR-12 compliant.

Before (no longer valid):
```php
<?php
declare(strict_types=1);
```

After (PSR-12 compliant):
```php
<?php

declare(strict_types=1);
```

If your codebase does not follow this convention yet, running `vendor/bin/ecs check --fix` will automatically add the blank lines.

If you want to keep the old behavior and skip this check, you can add it to your `ecs.php`:

```php
use PhpCsFixer\Fixer\Whitespace\BlankLineAfterOpeningTagFixer;

return ECSConfig::configure()
    // ...
    ->withSkip([
        BlankLineAfterOpeningTagFixer::class,
    ]);
```

### 4. Run the code style checks

After updating the namespace, run the code style checks to ensure everything is working correctly:

```bash
vendor/bin/ecs check
```

To automatically fix the code style issues (including the blank line after opening tag):

```bash
vendor/bin/ecs check --fix
```

### 5. Sanity check

You can ensure all predefined checks are loaded by running:

```sh
vendor/bin/ecs list-checkers
```

The output should show all the loaded checkers from both PHP-CS-Fixer and PHP_CodeSniffer.
