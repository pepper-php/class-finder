<?php

namespace Adagio\ClassFinder;

final class ClassFinder
{
    /**
     *
     * @var array
     */
    private $tokens = [];

    /**
     *
     * @var int
     */
    private $tokenCount = 0;

    /**
     *
     * @var int
     */
    private $index;

    /**
     *
     * @var string
     */
    private $namespace = '';

    /**
     *
     * @var array|string
     */
    private $token;

    /**
     * Returns the fully qualified names of classes defined in given source code.
     *
     * Searching in invalid PHP code has unpredictable result for ClassFinder.
     *
     * @param string $source
     *
     * @return string[] Array of fully qualified class names
     */
    public function find(string $source): array
    {
        $classes = [];
        $this->tokens = token_get_all($source);
        $this->tokenCount = count($this->tokens);
        $this->index = 0;

        while ($this->index < $this->tokenCount) {
            $this->token = $this->tokens[$this->index];

            if ($this->isNamespace()) {
                $this->namespace = $this->captureNamespace();
            }

            if ($this->isClass()) {
                $classes[] = $this->captureClass();
            }

            $this->index++;
        }

        return $classes;
    }

    /**
     *
     * @return bool
     */
    private function isClass()
    {
        if (!is_array($this->token)) {
            return false;
        }

        if (T_CLASS !== $this->token[0]) {
            return false;
        }

        if (T_DOUBLE_COLON === $this->tokens[$this->index - 1][0]) {
            return false;
        }

        return true;
    }

    /**
     *
     * @return string
     */
    private function captureClass()
    {
        $class = '';

        if ($this->namespace) {
            $class = $this->namespace.'\\';
        }

        return $class.$this->tokens[$this->index + 2][1];
    }

    /**
     *
     * @return bool
     */
    private function isNamespace()
    {
        return is_array($this->token) and T_NAMESPACE === $this->token[0];
    }

    /**
     *
     * @return string
     */
    private function captureNamespace()
    {
        $offset = 2;
        $ns = '';
        $token = $this->tokens[$this->index + $offset];

        if ('{' === $token) {
            return '';
        }

        do {
            $ns .= $token[1];
            $offset++;
            $token = $this->tokens[$this->index + $offset];
        } while (is_array($token) and ($token[0] === T_NS_SEPARATOR or $token[0] === T_STRING));

        return $ns;
    }
}
