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

        $this->plox = $plox;
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
            case '!':
                $this->addToken($this->match('=') ? TokenType::BANG_EQUAL_T : TokenType::BANG_T);
                break;
            case '=':
                $this->addToken($this->match('=') ? TokenType::EQUAL_EQUAL_T : TokenType::EQUAL_T);
                break;
            case '<':
                $this->addToken($this->match('=') ? TokenType::LESS_EQUAL_T : TokenType::LESS_T);
                break;
            case '>':
                $this->addToken($this->match('=') ? TokenType::GREATER_EQUAL_T : TokenType::GREATER_T);
                break;
            case '/':
                if ($this->match('/')) {
                    // A comment goes until the end of the line.
                    while ($this->peek() != '\n' && !$this->isAtEnd()) $this->advance();
                } else {
                    $this->addToken(TokenType::SLASH_T);
                }
                break;
            case ' ':
            case '\r':
            case '\t':
                // Ignore whitespace.
                break;
            case '\n':
                $this->line++;
                break;
            case '"':
                $this->string();
                break;
            default:
                if ($this->isDigit($c)) {
                    $this->number();
                } else {
                    $this->plox->error($this->line, "Unexpected character.");
                }
        }
    }

    protected function string()
    {
        while ($this->peek() != '"' && !$this->isAtEnd()) {
            if ($this->peek() == '\n') $this->line++;
            $this->advance();
        }

        if ($this->isAtEnd()) {
            $this->plox->error($this->line, "Unterminated string.");
            return;
        }

        // The closing ".
        $this->advance();

        // Trim the surrounding quotes.
        $value = substr($this->source, $this->start + 1, $this->current - 1);

        $this->addToken(TokenType::STRING_T, $value);
    }

    protected function addToken(TokenType $type, $literal = null)
    {
        $text = substr($this->source, $this->start, $this->current - $this->start);

        $this->tokens[] = new Token($type, $text, $literal, $this->line);
    }

    protected function isDigit(string $c): bool
    {
        return $c >= '0' && $c <= '9';
    }

    protected function number()
    {
        while ($this->isDigit($this->peek())) {
            $this->advance();
        }

        // Look for a fractional part.
        if ($this->peek() == '.' && $this->isDigit($this->peekNext())) {
            // Consume the "."
            $this->advance();

            while ($this->isDigit($this->peek())) {
                $this->advance();
            }
        }

        $this->addToken(
            TokenType::NUMBER_T,
            (float) substr($this->source, $this->start, $this->current)
        );
    }


    protected function match(string $expected): bool
    {
        if ($this->isAtEnd()) {
            return false;
        }

        if ($this->source[$this->current] !== $expected) {
            return false;
        }

        $this->current++;

        return true;
    }

    protected function peek(): string
    {
        if ($this->isAtEnd()) {
            return '\0';
        };

        return $this->source[$this->current];
    }

    protected function peekNext(): string
    {
        if ($this->current + 1 >= strlen($this->source)) {
            return '\0';
        }

        return $this->source[$this->current + 1];
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
