<?php

namespace Adagio\ClassFinder;

final class ClassFinder
{
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

        $tokens = token_get_all($source);
        $namespace = '';
        foreach ($tokens as $index => $token) {
            if (is_array($token) and
                T_NAMESPACE === $token[0]) {
                if (T_STRING === $tokens[$index + 2][0]) {
                    $namespace = $tokens[$index + 2][1];
                } else {
                    $namespace = '';
                }
            }

            if (is_array($token) and T_CLASS === $token[0]) {
                $classes[] = ($namespace ? $namespace.'\\' : '').$tokens[$index + 2][1];
            }
        }

        return $classes;
    }
}
