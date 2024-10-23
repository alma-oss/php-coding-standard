<?php

declare(strict_types=1);

use Lmc\CodingStandard\Set\SetList;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\PhpUnit\PhpUnitTestAnnotationFixer;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

/*
 * Internal rules configuration for the lmc/coding-standard project itself
 */
return ECSConfig::configure()
    ->withPaths([__DIR__ . '/src', __DIR__ . '/tests'])
    ->withRootFiles()
    ->withSets(
        [
            SetList::ALMACAREER,
        ],
    )
    ->withConfiguredRule(PhpUnitTestAnnotationFixer::class, ['style' => 'prefix'])
    ->withConfiguredRule(
        LineLengthFixer::class,
        ['line_length' => 120, 'break_long_lines' => true, 'inline_short_lines' => false],
    )
    ->withConfiguredRule(
        ClassAttributesSeparationFixer::class,
        ['elements' => ['const' => 'none', 'method' => 'one', 'property' => 'none']],
    )
    ->withSkip(
        [
            ForbiddenFunctionsSniff::class => ['tests/Integration/CodingStandardTest.php'],
        ],
    );
