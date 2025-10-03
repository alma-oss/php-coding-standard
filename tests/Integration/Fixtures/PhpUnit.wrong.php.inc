<?php

declare(strict_types=1);

namespace Lmc\CodingStandard\Integration\Fixtures;

use PHPUnit\Framework\TestCase;

/**
 * @covers Lmc\CodingStandard\Integration\Fixtures\MyClass
 */
class PhpUnit extends TestCase
{
    // PhpUnitSetUpTearDownVisibilityFixer
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testShouldDoSomething(): void
    {
        $data = true;

        // PhpUnitConstructFixer
        $this->assertSame(true, $data);

        // PhpUnitDedicateAssertFixer
        $this->assertTrue(str_contains('foo', 'o'));

        $this->assertSame(1, 2);
        // PhpUnitTestCaseStaticMethodCallsFixer
        self::assertSame(1, 2);
        // PhpUnitTestCaseStaticMethodCallsFixer
        static::assertSame(1, 2);
    }

    public function test_method_name(): void // PhpUnitMethodCasingFixer
    {
        $this->assertTrue(true);
    }
}
