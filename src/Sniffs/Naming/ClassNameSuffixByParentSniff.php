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

use Lmc\CodingStandard\Helper\Naming;
use Lmc\CodingStandard\Helper\SniffClassWrapper;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

final class ClassNameSuffixByParentSniff implements Sniff
{
    /** @var string */
    private const ERROR_MESSAGE = 'Class "%s" should have suffix "%s" by parent class/interface';

    /** @var string[] */
    public array $defaultParentClassToSuffixMap = [
        'Command',
        'Controller',
        'Repository',
        'Presenter',
        'Request',
        'Response',
        'FixerInterface',
        'Sniff',
        'Exception',
        'Handler',
    ];

    /** @var string[] */
    public array $extraParentTypesToSuffixes = [];

    /**
     * @return int[]
     */
    public function register(): array
    {
        return [T_CLASS];
    }

    public function process(File $phpcsFile, $stackPtr): void
    {
        $classWrapper = $this->getWrapperForFirstClassInFile($phpcsFile);
        if ($classWrapper === null) {
            return;
        }

        $className = $classWrapper->getClassName();
        if ($className === null) {
            return;
        }

        $parentClassName = $classWrapper->getParentClassName();
        if ($parentClassName) {
            $this->processType($phpcsFile, $parentClassName, $className, $stackPtr);
        }

        foreach ($classWrapper->getPartialInterfaceNames() as $interfaceName) {
            $this->processType($phpcsFile, $interfaceName, $className, $stackPtr);
        }
    }

    private function processType(File $file, string $currentParentType, string $className, int $position): void
    {
        foreach ($this->getClassToSuffixMap() as $parentType) {
            if (!fnmatch('*' . $parentType, $currentParentType)) {
                continue;
            }

            // the class that implements $currentParentType, should end with $suffix
            $suffix = $this->resolveExpectedSuffix($parentType);
            if (str_ends_with($className, $suffix)) {
                continue;
            }

            $file->addError(sprintf(self::ERROR_MESSAGE, $className, $suffix), $position, self::class);
        }
    }

    /**
     * @return string[]
     */
    private function getClassToSuffixMap(): array
    {
        return array_merge($this->defaultParentClassToSuffixMap, $this->extraParentTypesToSuffixes);
    }

    /**
     * - SomeInterface => Some
     * - AbstractSome => Some
     */
    private function resolveExpectedSuffix(string $parentType): string
    {
        if (str_ends_with($parentType, 'Interface')) {
            $parentType = mb_substr($parentType, 0, -mb_strlen('Interface'), 'UTF-8');
        }

        if (str_starts_with($parentType, 'Abstract')) {
            $parentType = mb_substr($parentType, mb_strlen('Abstract'), null, 'UTF-8');
        }

        return $parentType;
    }

    private function getWrapperForFirstClassInFile(File $file): ?SniffClassWrapper
    {
        $possibleClassPosition = $file->findNext(T_CLASS, 0);
        if (!is_int($possibleClassPosition)) {
            return null;
        }

        return new SniffClassWrapper($file, $possibleClassPosition, new Naming());
    }
}
