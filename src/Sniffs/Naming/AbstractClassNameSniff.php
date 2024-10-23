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

namespace Lmc\CodingStandard\Sniffs\Naming;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class AbstractClassNameSniff implements Sniff
{
    /**
     * @var string
     */
    private const ERROR_MESSAGE = 'Abstract class should have prefix "Abstract".';

    private int $position;
    private File $file;

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_CLASS];
    }

    public function process(File $phpcsFile, $stackPtr): void
    {
        $this->file = $phpcsFile;
        $this->position = $stackPtr;

        if ($this->shouldBeSkipped()) {
            return;
        }

        $phpcsFile->addError(self::ERROR_MESSAGE, $stackPtr, self::class);
    }

    private function shouldBeSkipped(): bool
    {
        $className = $this->getClassName();

        if (!$this->isClassAbstract() || $className === null) {
            return true;
        }

        return str_starts_with($className, 'Abstract');
    }

    private function isClassAbstract(): bool
    {
        $classProperties = $this->file->getClassProperties($this->position);

        return $classProperties['is_abstract'];
    }

    private function getClassName(): ?string
    {
        return $this->file->getDeclarationName($this->position);
    }
}
