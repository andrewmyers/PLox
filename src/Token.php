<?php

namespace AndrewMyers\PLox;

class Token
{
    public function __construct(
        public TokenType $type,
        public string $lexeme,
        public $literal,
        public int $line
    ) {
    }

    public function  __toString(): string
    {
        return $this->type->name . " " . $this->lexeme . " " . $this->literal;
    }
}
