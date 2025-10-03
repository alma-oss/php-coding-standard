<?php

declare(strict_types=1);

namespace Lmc\CodingStandard\Fixer;

use PhpCsFixer\Tokenizer\Tokens;
use PHPUnit\Framework\TestCase;

class SpecifyArgSeparatorFixerTest extends TestCase
{
    /**
     * @dataProvider provideFiles
     */
    public function testShouldFixCode(string $inputFile, string $expectedOutputFile): void
    {
        $fixer = new SpecifyArgSeparatorFixer();
        $fileInfo = new \SplFileInfo(__DIR__ . '/Fixtures/' . $inputFile);
        $fileContents = file_get_contents($fileInfo->getRealPath());
        if ($fileContents === false) {
            $this->fail('Could not read file ' . $fileInfo->getRealPath());
        }
        $tokens = Tokens::fromCode($fileContents);

        $fixer->fix($fileInfo, $tokens);

        $this->assertStringEqualsFile(
            __DIR__ . '/Fixtures/' . $expectedOutputFile,
            $tokens->generateCode(),
        );
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function provideFiles(): array
    {
        return [
            'Correct file should not be changed' => ['Correct.php.inc', 'Correct.php.inc'],
            'Wrong file should be fixed' => ['Wrong.php.inc', 'Fixed.php.inc'],
        ];
    }
}
