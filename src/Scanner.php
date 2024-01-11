<?php

namespace AndrewMyers\PLox;

class Scanner
{
    protected string $source;

    protected array $tokens = [];

    protected int $start = 0;

    protected int $current = 0;

    protected int $line = 1;

    public $plox;

    public function __construct(string $source, PLox $plox)
    {
        $this->source = $source;
    }

    public function scanTokens(): array
    {
        while (!$this->isAtEnd()) {
            $this->start = $this->current;
            $this->scanToken();
        }

        $this->tokens[] = new Token(TokenType::EOF_T, "", null, $this->line);

        return $this->tokens;
    }

    protected function scanToken()
    {
        $c = $this->advance();
        switch ($c) {
            case '(':
                $this->addToken(TokenType::LEFT_PAREN_T);
                break;
            case ')':
                $this->addToken(TokenType::RIGHT_PAREN_T);
                break;
            case '{':
                $this->addToken(TokenType::LEFT_BRACE_T);
                break;
            case '}':
                $this->addToken(TokenType::RIGHT_BRACE_T);
                break;
            case ',':
                $this->addToken(TokenType::COMMA_T);
                break;
            case '.':
                $this->addToken(TokenType::DOT_T);
                break;
            case '-':
                $this->addToken(TokenType::MINUS_T);
                break;
            case '+':
                $this->addToken(TokenType::PLUS_T);
                break;
            case ';':
                $this->addToken(TokenType::SEMICOLON_T);
                break;
            case '*':
                $this->addToken(TokenType::STAR_T);
                break;
            default:
                $this->plox->error($this->line, "Unexpected Character.");
        }
    }

    protected function addToken(TokenType $type, $literal = null)
    {
        $text = substr($this->source, $this->start, $this->current - $this->start);

        $this->tokens[] = new Token($type, $text, $literal, $this->line);
    }

    protected function advance(): string
    {
        return $this->source[$this->current++];
    }

    protected function isAtEnd(): bool
    {
        return $this->current >= strlen($this->source);
    }
}
