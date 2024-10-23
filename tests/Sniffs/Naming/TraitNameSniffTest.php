<?php

declare(strict_types=1);

namespace Lmc\CodingStandard\Sniffs\Naming;

use Lmc\CodingStandard\Sniffs\AbstractSniffTestCase;

class TraitNameSniffTest extends AbstractSniffTestCase
{
    /**
     * @dataProvider provideFixtures
     *
     * @param array<int, string> $expectedErrors
     */
    public function testShouldFixCode(string $fixtureFile, array $expectedErrors): void
    {
        $sniff = $this->applyFixturesToSniff($fixtureFile);
        $sniff->process();

        $foundErrors = $sniff->getErrors();

        $this->assertErrors($expectedErrors, $foundErrors);
    }

    /**
     * @return array<string, array{string, array<int, string>}>
     */
    public static function provideFixtures(): array
    {
        return [
            'wrongly named' => [
                __DIR__ . '/Fixtures/TraitNameSniffTest.wrong.php.inc',
                [5 => 'Trait should have suffix "Trait".'],
            ],
            'properly named' => [__DIR__ . '/Fixtures/TraitNameSniffTest.correct.php.inc', []],
        ];
    }

    protected function getSniffFile(): string
    {
        return __DIR__ . '/../../../src/Sniffs/Naming/TraitNameSniff.php';
    }
}
