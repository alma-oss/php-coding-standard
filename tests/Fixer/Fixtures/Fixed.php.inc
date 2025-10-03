<?php

declare(strict_types=1);

/**
 * The function declaration should not be affected
 */
function http_build_query(
    $data, // TODO: array|object in PHP 8.0+
    string $numeric_prefix = '',
    ?string $arg_separator = null,
    int $encoding_type = PHP_QUERY_RFC1738
): string {
    return 'foo';
}

function assembleQueryString(): void
{
    $queryString1 = http_build_query(['foo' => 'bar'], '', '&');

    $queryString2 = http_build_query(['foo' => 'bar'], '', '&');

    $queryString3 = http_build_query(['foo' => 'bar'], '', '&');

    $queryString4 = http_build_query(['foo' => 'bar'], '', '&', PHP_QUERY_RFC3986);

    $queryString5 = http_build_query(['foo' => 'bar'], 'prefix', '&', PHP_QUERY_RFC3986);

    $queryString6 = http_build_query(['foo' => 'bar', 'baz' => 'ban'], '', '&', PHP_QUERY_RFC3986);

    $queryString7 = http_build_query((object) ['foo' => 'bar', 'baz' => 'ban'], '', '&', PHP_QUERY_RFC3986);
}
