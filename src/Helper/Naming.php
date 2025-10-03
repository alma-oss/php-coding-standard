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
use SlevomatCodingStandard\Helpers\NamespaceHelper;
use SlevomatCodingStandard\Helpers\ReferencedNameHelper;

final class Naming
{
    /**
     * @var string
     */
    private const NAMESPACE_SEPARATOR = '\\';

    /**
     * @var mixed[][]
     */
    private array $referencedNamesByFilePath = [];

    /**
     * @var string[][]
     */
    private array $fqnClassNameByFilePathAndClassName = [];

    public function getClassName(File $file, int $classNameStartPosition): string
    {
        $tokens = $file->getTokens();

        $firstNamePart = $tokens[$classNameStartPosition]['content'];

        // is class <name>
        if ($this->isClassName($file, $classNameStartPosition)) {
            $namespace = NamespaceHelper::findCurrentNamespaceName($file, $classNameStartPosition);
            if ($namespace) {
                return $namespace . '\\' . $firstNamePart;
            }

            return $firstNamePart;
        }

        $classNameParts = [];
        $classNameParts[] = $firstNamePart;

        $nextTokenPointer = $classNameStartPosition + 1;
        while ($tokens[$nextTokenPointer]['code'] === T_NS_SEPARATOR) {
            ++$nextTokenPointer;
            $classNameParts[] = $tokens[$nextTokenPointer]['content'];
            ++$nextTokenPointer;
        }

        $completeClassName = implode(self::NAMESPACE_SEPARATOR, $classNameParts);

        $fqnClassName = $this->getFqnClassName($file, $completeClassName, $classNameStartPosition);
        if ($fqnClassName !== '') {
            return mb_ltrim($fqnClassName, self::NAMESPACE_SEPARATOR);
        }

        return $completeClassName;
    }

    private function getFqnClassName(File $file, string $className, int $classTokenPosition): string
    {
        $referencedNames = $this->getReferencedNames($file);

        foreach ($referencedNames as $referencedName) {
            if (isset($this->fqnClassNameByFilePathAndClassName[$file->path][$className])) {
                return $this->fqnClassNameByFilePathAndClassName[$file->path][$className];
            }

            $resolvedName = NamespaceHelper::resolveClassName(
                $file,
                $referencedName->getNameAsReferencedInFile(),
                $classTokenPosition,
            );

            if ($referencedName->getNameAsReferencedInFile() === $className) {
                $this->fqnClassNameByFilePathAndClassName[$file->path][$className] = $resolvedName;

                return $resolvedName;
            }
        }

        return '';
    }

    /**
     * As in:
     * class <name>
     */
    private function isClassName(File $file, int $position): bool
    {
        return (bool) $file->findPrevious(T_CLASS, $position, max(1, $position - 3));
    }

    /**
     * @return mixed[]
     */
    private function getReferencedNames(File $file): array
    {
        if (isset($this->referencedNamesByFilePath[$file->path])) {
            return $this->referencedNamesByFilePath[$file->path];
        }

        $referencedNames = ReferencedNameHelper::getAllReferencedNames($file, 0);

        $this->referencedNamesByFilePath[$file->path] = $referencedNames;

        return $referencedNames;
    }
}
