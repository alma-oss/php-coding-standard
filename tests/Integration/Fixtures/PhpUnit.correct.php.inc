<?php

declare(strict_types=1);

namespace Lmc\CodingStandard\Integration\Fixtures;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Lmc\CodingStandard\Integration\Fixtures\MyClass
 */
class PhpUnit extends TestCase
{
    // PhpUnitSetUpTearDownVisibilityFixer
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testShouldDoSomething(): void
    {
        $data = true;

        // PhpUnitConstructFixer
        $this->assertTrue($data);

        // PhpUnitDedicateAssertFixer
        $this->assertStringContainsString('o', 'foo');

        $this->assertSame(1, 2);
        // PhpUnitTestCaseStaticMethodCallsFixer
        $this->assertSame(1, 2);
        // PhpUnitTestCaseStaticMethodCallsFixer
        $this->assertSame(1, 2);
    }

    public function testMethodName(): void // PhpUnitMethodCasingFixer
    {
        $this->assertTrue(true);
    }
}
