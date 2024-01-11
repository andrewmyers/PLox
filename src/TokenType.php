<?php

namespace AndrewMyers\PLox;

enum TokenType: string
{
        // Single-character tokens.
    case LEFT_PAREN_T = "LEFT_PAREN_T";
    case RIGHT_PAREN_T = "RIGHT_PAREN_T";
    case LEFT_BRACE_T = "LEFT_BRACE_T";
    case    RIGHT_BRACE_T = "RIGHT_BRACE_T";
    case    COMMA_T = "COMMA_T";
    case    DOT_T = "DOT_T";
    case    MINUS_T = "MINUS_T";
    case    PLUS_T = "PLUS_T";
    case    SEMICOLON_T = "SEMICOLON_T";
    case    SLASH_T = "SLASH_T";
    case    STAR_T = "STAR_T";

    case    BANG_T = "BANG_T";
    case    BANG_EQUAL_T = "BANG_EQUAL_T";
    case    EQUAL_T = "EQUAL_T";
    case    EQUAL_EQUAL_T = "EQUAL_EQUAL_T";
    case    GREATER_T = "GREATER_T";
    case    GREATER_EQUAL_T = "GREATER_EQUAL_T";
    case    LESS_T = "LESS_T";
    case    LESS_EQUAL_T = "LESS_EQUAL_T";

        // Literals_T.
    case    IDENTIFIER_T = "IDENTIFIER_T";
    case    STRING_T = "STRING_T";
    case    NUMBER_T = "NUMBER_T";

        // Keywords_T.
    case    AND_T = "AND_T";
    case    CLASS_T = "CLASS_T";
    case    ELSE_T = "ELSE_T";
    case    FALSE_T = "FALSE_T";
    case    FUN_T = "FUN_T";
    case    FOR_T = "FOR_T";
    case    IF_T = "IF_T";
    case    NIL_T = "NIL_T";
    case    OR_T = "OR_T";
    case    PRINT_T = "PRINT_T";
    case    RETURN_T = "RETURN_T";
    case    SUPER_T = "SUPER_T";
    case    THIS_T = "THIS_T";
    case    TRUE_T = "TRUE_T";
    case    VAR_T = "VAR_T";
    case    WHILE_T = "WHILE_T";

    case    EOF_T = "EOF_T";
}
