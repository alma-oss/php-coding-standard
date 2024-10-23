<?php

declare(strict_types=1);

/*
 * Originally part of https://github.com/symplify/symplify
 *
 * MIT License
 *
 * (c) 2020 Tomas Votruba <tomas.vot@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Lmc\CodingStandard\Helper;

use PHP_CodeSniffer\Files\File;
use SlevomatCodingStandard\Helpers\TokenHelper;

final class SniffClassWrapper
{
    public function __construct(private File $file, private int $position, private Naming $naming) {}

    public function getClassName(): ?string
    {
        return $this->naming->getClassName($this->file, $this->position + 2);
    }

    /**
     * @return string[]
     */
    public function getPartialInterfaceNames(): array
    {
        if (!$this->doesImplementInterface()) {
            return [];
        }

        $implementPosition = $this->getImplementsPosition();
        if (!is_int($implementPosition)) {
            return [];
        }

        $openBracketPosition = $this->file->findNext(T_OPEN_CURLY_BRACKET, $this->position, $this->position + 15);

        // anonymous class
        if (!$openBracketPosition) {
            return [];
        }

        $interfacePartialNamePosition = $this->file->findNext(T_STRING, $implementPosition, $openBracketPosition);

        $partialInterfacesNames = [];
        $partialInterfacesNames[] = $this->file->getTokens()[$interfacePartialNamePosition]['content'];

        return $partialInterfacesNames;
    }

    public function doesImplementInterface(): bool
    {
        return (bool) $this->getImplementsPosition();
    }

    public function doesExtendClass(): bool
    {
        return (bool) $this->file->findNext(T_EXTENDS, $this->position, $this->position + 5);
    }

    public function getParentClassName(): ?string
    {
        $extendsTokenPosition = TokenHelper::findNext($this->file, T_EXTENDS, $this->position, $this->position + 10);
        if ($extendsTokenPosition === null) {
            return null;
        }

        $parentClassPosition = (int) TokenHelper::findNext($this->file, T_STRING, $extendsTokenPosition);

        return $this->naming->getClassName($this->file, $parentClassPosition);
    }

    private function getImplementsPosition(): bool|int
    {
        return $this->file->findNext(T_IMPLEMENTS, $this->position, $this->position + 15);
    }
}
