<?php declare(strict_types=1);

namespace Lmc\CodingStandard\Integration;

use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
class CodingStandardTest extends TestCase
{
    private string $tempFixtureFile;

    /** @after */
    protected function cleanUpTempFixtureFile(): void
    {
        unlink($this->tempFixtureFile);
    }

    /**
     * @test
     * @dataProvider provideFilesToFix
     */
    public function shouldFixFile(string $wrongFile, string $correctFile): void
    {
        $fixedFile = $this->runEcsCheckOnFile($wrongFile);

        $this->assertStringEqualsFile($correctFile, file_get_contents($fixedFile));
    }

    public function provideFilesToFix(): array
    {
        return [
            'Basic' => [__DIR__ . '/Fixtures/Basic.wrong.php.inc', __DIR__ . '/Fixtures/Basic.correct.php.inc'],
            'NewPhpFeatures' => [
                __DIR__ . '/Fixtures/NewPhpFeatures.wrong.php.inc',
                __DIR__ . '/Fixtures/NewPhpFeatures.correct.php.inc',
            ],
            'PhpDoc' => [__DIR__ . '/Fixtures/PhpDoc.wrong.php.inc', __DIR__ . '/Fixtures/PhpDoc.correct.php.inc'],
            'PhpUnit' => [__DIR__ . '/Fixtures/PhpUnit.wrong.php.inc', __DIR__ . '/Fixtures/PhpUnit.correct.php.inc'],
        ];
    }

    /**
     * @test
     * @requires PHP >= 8.1
     */
    public function shouldFixPhp81(): void
    {
        $fixedFile = $this->runEcsCheckOnFile(__DIR__ . '/Fixtures/Php81.wrong.php.inc');

        $this->assertStringEqualsFile(
            __DIR__ . '/Fixtures/Php81.correct.php.inc',
            file_get_contents($fixedFile),
        );
    }

    /**
     * @test
     * @requires PHP >= 8.2
     */
    public function shouldFixPhp82(): void
    {
        $fixedFile = $this->runEcsCheckOnFile(__DIR__ . '/Fixtures/Php82.wrong.php.inc');

        $this->assertStringEqualsFile(
            __DIR__ . '/Fixtures/Php82.correct.php.inc',
            file_get_contents($fixedFile),
        );
    }

    private function runEcsCheckOnFile(string $file): string
    {
        $fixtureFile = $this->initTempFixtureFile();

        // copy source of wrongFile to a temporary file which will be modified by ECS
        copy($file, $fixtureFile);

        shell_exec(
            sprintf(
                '%s/../../vendor/bin/ecs check --no-progress-bar --no-ansi --no-interaction --fix %s',
                __DIR__,
                $fixtureFile,
            ),
        );

        return $fixtureFile;
    }

    private function initTempFixtureFile(): string
    {
        // Create new file in temporary directory
        $fixtureFile = tempnam(sys_get_temp_dir(), 'ecs-test');
        if ($fixtureFile === false) {
            $this->fail('Could not create temporary file');
        }
        $this->tempFixtureFile = $fixtureFile; // store to be able to remove it later

        return $fixtureFile;
    }
}
