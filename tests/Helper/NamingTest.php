<?php

declare(strict_types=1);

namespace Lmc\CodingStandard\Helper;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\LocalFile;
use PHP_CodeSniffer\Ruleset;
use PHPUnit\Framework\TestCase;

/**
 * Test for the Naming helper class.
 */
class NamingTest extends TestCase
{
    private Naming $naming;

    protected function setUp(): void
    {
        $this->naming = new Naming();
    }

    public function testShouldGetSimpleClassNameWithNamespace(): void
    {
        $code = <<<'PHP'
            <?php
            namespace App\Service;

            class UserService
            {
            }
            PHP;

        $file = $this->createFileFromCode($code);
        $classPosition = $this->findTokenPosition($file, T_STRING, 'UserService');

        $result = $this->naming->getClassName($file, $classPosition);

        $this->assertSame('App\\Service\\UserService', $result);
    }

    public function testShouldGetClassNameWithoutNamespace(): void
    {
        $code = <<<'PHP'
            <?php

            class SimpleClass
            {
            }
            PHP;

        $file = $this->createFileFromCode($code);
        $classPosition = $this->findTokenPosition($file, T_STRING, 'SimpleClass');

        $result = $this->naming->getClassName($file, $classPosition);

        $this->assertSame('SimpleClass', $result);
    }

    public function testShouldGetFullyQualifiedClassNameFromExtends(): void
    {
        $code = <<<'PHP'
            <?php
            namespace App\Service;

            use App\Repository\UserRepository;

            class UserService extends UserRepository
            {
            }
            PHP;

        $file = $this->createFileFromCode($code);
        $parentClassPosition = $this->findTokenPosition($file, T_STRING, 'UserRepository', 2);

        $result = $this->naming->getClassName($file, $parentClassPosition);

        $this->assertSame('App\\Repository\\UserRepository', $result);
    }

    public function testShouldGetFullyQualifiedClassNameFromImplements(): void
    {
        $code = <<<'PHP'
            <?php
            namespace App\Service;

            use App\Contract\ServiceInterface;

            class UserService implements ServiceInterface
            {
            }
            PHP;

        $file = $this->createFileFromCode($code);
        $interfacePosition = $this->findTokenPosition($file, T_STRING, 'ServiceInterface', 2);

        $result = $this->naming->getClassName($file, $interfacePosition);

        $this->assertSame('App\\Contract\\ServiceInterface', $result);
    }

    public function testShouldCacheReferencedNamesForSameFile(): void
    {
        $code = <<<'PHP'
            <?php
            namespace App\Service;

            use App\Repository\UserRepository;

            class UserService extends UserRepository
            {
            }
            PHP;

        $file = $this->createFileFromCode($code);
        $position = $this->findTokenPosition($file, T_STRING, 'UserRepository', 2);

        // Call twice to test caching
        $result1 = $this->naming->getClassName($file, $position);
        $result2 = $this->naming->getClassName($file, $position);

        $this->assertSame($result1, $result2);
        $this->assertSame('App\\Repository\\UserRepository', $result1);
    }

    public function testShouldHandleNamespaceWithMultipleLevels(): void
    {
        $code = <<<'PHP'
            <?php
            namespace Very\Deep\Nested\Namespace\Structure;

            class DeepClass
            {
            }
            PHP;

        $file = $this->createFileFromCode($code);
        $classPosition = $this->findTokenPosition($file, T_STRING, 'DeepClass');

        $result = $this->naming->getClassName($file, $classPosition);

        $this->assertSame('Very\\Deep\\Nested\\Namespace\\Structure\\DeepClass', $result);
    }

    public function testShouldHandleFullyQualifiedClassReference(): void
    {
        $code = <<<'PHP'
            <?php
            namespace App\Service;

            class UserService extends \Fully\Qualified\BaseService
            {
            }
            PHP;

        $file = $this->createFileFromCode($code);
        $baseClassPosition = $this->findTokenPosition($file, T_STRING, 'Fully');

        $result = $this->naming->getClassName($file, $baseClassPosition);

        // When using fully qualified name, it should return the resolved name
        $this->assertStringContainsString('Fully', $result);
    }

    public function testShouldHandleAbstractClass(): void
    {
        $code = <<<'PHP'
            <?php
            namespace App\Service;

            abstract class AbstractUserService
            {
            }
            PHP;

        $file = $this->createFileFromCode($code);
        $classPosition = $this->findTokenPosition($file, T_STRING, 'AbstractUserService');

        $result = $this->naming->getClassName($file, $classPosition);

        $this->assertSame('App\\Service\\AbstractUserService', $result);
    }

    public function testShouldHandleClassWithInterface(): void
    {
        $code = <<<'PHP'
            <?php
            namespace App\Service;

            interface UserServiceInterface
            {
            }
            PHP;

        $file = $this->createFileFromCode($code);
        $interfacePosition = $this->findTokenPosition($file, T_STRING, 'UserServiceInterface');

        $result = $this->naming->getClassName($file, $interfacePosition);

        // For interface declarations, it returns just the interface name (not FQN)
        $this->assertSame('UserServiceInterface', $result);
    }

    public function testShouldHandleMultipleClassesInFile(): void
    {
        $code = <<<'PHP'
            <?php
            namespace App\Service;

            class FirstClass
            {
            }

            class SecondClass
            {
            }
            PHP;

        $file = $this->createFileFromCode($code);

        $firstPosition = $this->findTokenPosition($file, T_STRING, 'FirstClass');
        $secondPosition = $this->findTokenPosition($file, T_STRING, 'SecondClass');

        $result1 = $this->naming->getClassName($file, $firstPosition);
        $result2 = $this->naming->getClassName($file, $secondPosition);

        $this->assertSame('App\\Service\\FirstClass', $result1);
        $this->assertSame('App\\Service\\SecondClass', $result2);
    }

    public function testShouldHandleAliasedImport(): void
    {
        $code = <<<'PHP'
            <?php
            namespace App\Service;

            use App\Repository\UserRepository as UserRepo;

            class UserService extends UserRepo
            {
            }
            PHP;

        $file = $this->createFileFromCode($code);
        $parentPosition = $this->findTokenPosition($file, T_STRING, 'UserRepo', 2);

        $result = $this->naming->getClassName($file, $parentPosition);

        // Should resolve the aliased import
        $this->assertSame('App\\Repository\\UserRepository', $result);
    }

    public function testShouldReturnClassNameForReferencedClassNotInUseStatements(): void
    {
        $code = <<<'PHP'
            <?php
            namespace App\Service;

            class UserService extends SomeClass
            {
            }
            PHP;

        $file = $this->createFileFromCode($code);
        $parentPosition = $this->findTokenPosition($file, T_STRING, 'SomeClass');

        $result = $this->naming->getClassName($file, $parentPosition);

        // When class is not in use statements, it resolves relative to current namespace
        $this->assertSame('App\\Service\\SomeClass', $result);
    }

    public function testShouldHandleLeadingBackslashInResolvedName(): void
    {
        $code = <<<'PHP'
            <?php
            namespace App\Service;

            use App\Contract\ServiceInterface;

            class UserService implements ServiceInterface
            {
            }
            PHP;

        $file = $this->createFileFromCode($code);
        $interfacePosition = $this->findTokenPosition($file, T_STRING, 'ServiceInterface', 2);

        $result = $this->naming->getClassName($file, $interfacePosition);

        // Should not start with backslash (mb_ltrim is used)
        $this->assertStringStartsNotWith('\\', $result);
        $this->assertSame('App\\Contract\\ServiceInterface', $result);
    }

    /**
     * Create a File object from PHP code string
     */
    private function createFileFromCode(string $code): LocalFile
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'phpcs_test_');
        if ($tempFile === false) {
            $this->fail('Could not create temporary file');
        }
        file_put_contents($tempFile, $code);

        $config = new Config();
        $ruleset = new Ruleset($config);

        $file = new LocalFile($tempFile, $ruleset, $config);
        $file->parse();

        return $file;
    }

    /**
     * Find the position of a token with specific content
     */
    private function findTokenPosition(LocalFile $file, int $tokenType, string $content, int $occurrence = 1): int
    {
        $tokens = $file->getTokens();
        $found = 0;

        foreach ($tokens as $position => $token) {
            if ($token['code'] === $tokenType && $token['content'] === $content) {
                $found++;
                if ($found === $occurrence) {
                    return $position;
                }
            }
        }

        $this->fail("Could not find token {$content} (occurrence {$occurrence})");
    }
}
