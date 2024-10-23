<?php

declare(strict_types=1);

namespace Lmc\CodingStandard\Fixer\Fixtures;

class Correct
{
    public function assembleQueryString(): void
    {
        $queryString1 = http_build_query(['foo' => 'bar'], '', '&');

        $queryString1WithMultipleWhitespaces = http_build_query(['foo' => 'bar'], 'prefix',   '&');

        $queryString1WithWhitespacesAndComments = http_build_query(['foo' => 'bar'], '', /* comment */  '&' /* x */);

        $queryString1WithComment = http_build_query(['foo' => 'bar'], /* Comment, with commas, */ '' ,  '&');

        $queryString1WithObject = http_build_query((object) ['foo' => 'bar'], '', '&');

        $queryString2 = http_build_query(['foo' => 'bar', 'baz' => 'bat'], '', '&');

        $queryString3 = http_build_query(['foo' => 'bar'], '', '&amp;');

        $queryString4 = http_build_query(['foo' => 'bar'], '', ';');
    }
}
