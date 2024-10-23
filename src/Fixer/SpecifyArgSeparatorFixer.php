<?php

declare(strict_types=1);

namespace Lmc\CodingStandard\Fixer;

use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Analyzer\ArgumentsAnalyzer;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;

class SpecifyArgSeparatorFixer implements FixerInterface
{
    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'Function `http_build_query()` should always have specified `$arg_separator` argument',
            [
                new CodeSample("<?php\n\$queryString = http_build_query(['foo' => 'bar', 'baz' => 'bat']);"),
            ],
            'Function `http_build_query()` uses `arg_separator.output` ini directive as default argument separator, '
            . 'however when its default value "&" is changed, query string assembled by the method will be '
            . 'unexpectedly invalid. This Fixer forces you to not rely on ini settings and rather define '
            . '`$arg_separator` in third argument of the function.',
            'Risky when other than default "&" argument separator should be used in query strings.',
        );
    }

    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isTokenKindFound(T_STRING);
    }

    public function isRisky(): bool
    {
        return true;
    }

    public function fix(\SplFileInfo $file, Tokens $tokens): void
    {
        foreach ($tokens as $index => $token) {
            if ($token->isGivenKind(T_STRING) && $token->getContent() === 'http_build_query') {
                if ($this->isFunctionCall($tokens, $index)) {
                    continue;
                }

                $this->fixFunction($tokens, $index);
            }
        }
    }

    public function getName(): string
    {
        return self::class;
    }

    public function getPriority(): int
    {
        // Should be run after SingleQuoteFixer (priority 0) and ArraySyntaxFixer (priority 1)
        return -1;
    }

    public function supports(\SplFileInfo $file): bool
    {
        return true;
    }

    private function fixFunction(Tokens $tokens, int $functionIndex): void
    {
        $openParenthesisIndex = $tokens->getNextTokenOfKind($functionIndex, ['(']);
        if ($openParenthesisIndex === null) {
            return;
        }

        $closeParenthesisIndex = $tokens->findBlockEnd(Tokens::BLOCK_TYPE_PARENTHESIS_BRACE, $openParenthesisIndex);

        $argumentCount = (new ArgumentsAnalyzer())
            ->countArguments($tokens, $openParenthesisIndex, $closeParenthesisIndex);

        // When third argument is already present and it is null, override its value.
        if ($argumentCount >= 3) {
            $thirdArgumentTuple = $this->getThirdArgumentTokenTuple(
                $tokens,
                $openParenthesisIndex,
                $closeParenthesisIndex,
            );
            if ($thirdArgumentTuple === []) {
                return;
            }

            $thirdArgumentToken = reset($thirdArgumentTuple);
            if ($thirdArgumentToken->getContent() === 'null') {
                $this->setArgumentValueToAmp($tokens, key($thirdArgumentTuple));
            }

            return;
        }

        $tokensToInsert = [];

        // Add second argument if not defined
        if ($argumentCount === 1) {
            $tokensToInsert[] = new Token(',');
            $tokensToInsert[] = new Token([T_WHITESPACE, ' ']);
            $tokensToInsert[] = new Token([T_STRING, "''"]);
        }

        // Add third argument (arg separator): ", '&'"
        $tokensToInsert[] = new Token(',');
        $tokensToInsert[] = new Token([T_WHITESPACE, ' ']);
        $tokensToInsert[] = new Token([T_STRING, "'&'"]);

        $beforeCloseParenthesisIndex = $tokens->getPrevNonWhitespace($closeParenthesisIndex);
        $tokens->insertAt($beforeCloseParenthesisIndex + 1, $tokensToInsert);
    }

    /**
     * Detect if this is most probably function call (and not function import or function definition).
     */
    private function isFunctionCall(Tokens $tokens, int $index): bool
    {
        $previousIndex = $tokens->getPrevMeaningfulToken($index);

        return $previousIndex !== null
            && ($tokens[$previousIndex]->isGivenKind(CT::T_FUNCTION_IMPORT)
                || $tokens[$previousIndex]->isGivenKind(T_FUNCTION));
    }

    /**
     * @return array<int, Token>
     */
    private function getThirdArgumentTokenTuple(
        Tokens $tokens,
        int $openParenthesisIndex,
        int $closeParenthesisIndex,
    ): array {
        $argumentsAnalyzer = new ArgumentsAnalyzer();
        $allArguments = $argumentsAnalyzer->getArguments($tokens, $openParenthesisIndex, $closeParenthesisIndex);
        $thirdArgumentIndex = array_slice($allArguments, 2, 1, true);

        for ($index = key($thirdArgumentIndex); $index <= reset($thirdArgumentIndex); $index++) {
            /** @var int $index */
            /** @var Token $token */
            $token = $tokens[$index];

            if (!$token->isWhitespace() && !$token->isComment()) {
                return [$index => $token];
            }
        }

        return [];
    }

    private function setArgumentValueToAmp(Tokens $tokens, int $argumentStartIndex): void
    {
        $ampToken = new Token([T_STRING, "'&'"]);
        $tokens->offsetSet($argumentStartIndex, $ampToken);
    }
}
