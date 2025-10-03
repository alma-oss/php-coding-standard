<?php

declare(strict_types=1);

namespace Lmc\CodingStandard\Helper;

use PHPUnit\Framework\TestCase;

/**
 * Test for the mb_ltrim() polyfill function.
 *
 * Note: This test ensures the polyfill works correctly on PHP 8.0-8.3.
 * On PHP 8.4+, the native function will be used instead.
 */
class PolyfillTest extends TestCase
{
    public function testShouldTrimLeadingBackslashFromClassName(): void
    {
        $input = '\\Foo\\Bar\\ClassName';
        $expected = 'Foo\\Bar\\ClassName';

        $result = mb_ltrim($input, '\\');

        $this->assertSame($expected, $result);
    }

    public function testShouldTrimMultipleLeadingBackslashes(): void
    {
        $input = '\\\\\\Foo\\Bar';
        $expected = 'Foo\\Bar';

        $result = mb_ltrim($input, '\\');

        $this->assertSame($expected, $result);
    }

    public function testShouldNotTrimTrailingBackslashes(): void
    {
        $input = 'Foo\\Bar\\';
        $expected = 'Foo\\Bar\\';

        $result = mb_ltrim($input, '\\');

        $this->assertSame($expected, $result);
    }

    public function testShouldNotTrimMiddleBackslashes(): void
    {
        $input = 'Foo\\Bar\\Baz';
        $expected = 'Foo\\Bar\\Baz';

        $result = mb_ltrim($input, '\\');

        $this->assertSame($expected, $result);
    }

    public function testShouldReturnUnchangedStringWithoutLeadingCharacters(): void
    {
        $input = 'FooBarBaz';
        $expected = 'FooBarBaz';

        $result = mb_ltrim($input, '\\');

        $this->assertSame($expected, $result);
    }

    public function testShouldTrimDefaultWhitespaceCharacters(): void
    {
        $input = "  \t\n\r\v\0Hello World";
        $expected = 'Hello World';

        $result = mb_ltrim($input);

        $this->assertSame($expected, $result);
    }

    public function testShouldTrimCustomCharacters(): void
    {
        $input = 'aaabbbcccHello';
        $expected = 'Hello';

        $result = mb_ltrim($input, 'abc');

        $this->assertSame($expected, $result);
    }

    public function testShouldTrimMultipleWhitespaceTypes(): void
    {
        $input = "   \t\n   Text";
        $expected = 'Text';

        $result = mb_ltrim($input);

        $this->assertSame($expected, $result);
    }

    public function testShouldHandleEmptyString(): void
    {
        $input = '';
        $expected = '';

        $result = mb_ltrim($input, '\\');

        $this->assertSame($expected, $result);
    }

    public function testShouldHandleStringWithOnlyTrimmedCharacters(): void
    {
        $input = '\\\\\\';
        $expected = '';

        $result = mb_ltrim($input, '\\');

        $this->assertSame($expected, $result);
    }

    public function testShouldHandleSpecialRegexCharacters(): void
    {
        $input = '...+++***Text';
        $expected = 'Text';

        $result = mb_ltrim($input, '.+*');

        $this->assertSame($expected, $result);
    }

    public function testShouldHandleMultibyteCharacters(): void
    {
        $input = '€€€€Hello';
        $expected = 'Hello';

        $result = mb_ltrim($input, '€');

        $this->assertSame($expected, $result);
    }

    public function testShouldHandleUnicodeCharacters(): void
    {
        $input = '👋👋👋Hello';
        $expected = 'Hello';

        $result = mb_ltrim($input, '👋');

        $this->assertSame($expected, $result);
    }

    public function testShouldTrimMixedCharacters(): void
    {
        $input = ' \\  \\ Text';
        $expected = 'Text';

        $result = mb_ltrim($input, ' \\');

        $this->assertSame($expected, $result);
    }

    public function testShouldWorkWithSingleCharacter(): void
    {
        $input = '\\';
        $expected = '';

        $result = mb_ltrim($input, '\\');

        $this->assertSame($expected, $result);
    }

    public function testShouldPreserveInternalStructure(): void
    {
        $input = '\\Namespace\\SubNamespace\\Class';
        $expected = 'Namespace\\SubNamespace\\Class';

        $result = mb_ltrim($input, '\\');

        $this->assertSame($expected, $result);
        $this->assertStringContainsString('\\', $result);
        $this->assertStringStartsNotWith('\\', $result);
    }
}
