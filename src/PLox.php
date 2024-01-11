<?php

namespace AndrewMyers\PLox;

class PLox
{
    public $hadError = false;

    public function __invoke(int $argc, array $args)
    {
        if ($argc > 2) {
            echo "Usage: PLox [script]";
        } else if ($argc === 2) {
            $this->runFile($args[1]);
        } else {
            $this->runPrompt();
        }
    }

    public function runFile(string $path)
    {

        $this->run(file_get_contents($path));

        if ($this->hadError) {
            exit(65);
        }
    }

    public function runPrompt()
    {
        while (true) {
            $input = readline("> ");

            if ($input) {
                $this->run($input);
                $this->hadError = false;
            } else {
                break;
            }
        }
    }

    protected function run(string $source)
    {
        $scanner = new Scanner($source, $this);

        $tokens  = $scanner->scanTokens();

        foreach ($tokens as $token) {
            echo $token . PHP_EOL;
        }
    }

    public function error(int $line, string $message)
    {
        $this->report($line, "", $message);
    }

    public function report(int $line, string $where, string $message)
    {
        $this->hadError = true;

        echo "[line: $line]: Error $where: $message" . PHP_EOL;
    }
}
