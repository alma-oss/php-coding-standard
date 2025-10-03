<?php

declare(strict_types=1);

namespace Lmc\CodingStandard\Sniffs\Naming;

use Lmc\CodingStandard\Sniffs\AbstractSniffTestCase;

class InterfaceNameSniffTest extends AbstractSniffTestCase
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
                __DIR__ . '/Fixtures/InterfaceNameSniffTest.wrong.php.inc',
                [5 => 'Interface should have suffix "Interface".'],
            ],
            'properly named' => [__DIR__ . '/Fixtures/InterfaceNameSniffTest.correct.php.inc', []],
        ];
    }

    protected function getSniffFile(): string
    {
        return __DIR__ . '/../../../src/Sniffs/Naming/InterfaceNameSniff.php';
    }
}
