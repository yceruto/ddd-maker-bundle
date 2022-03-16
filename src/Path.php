<?php

/*
 * This file is part of the DddBundle package.
 *
 * (c) Yonel Ceruto <yonelceruto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yceruto\DddMakerBundle;

final class Path
{
    private string $relativePath;
    private string $offsetPath;
    private string $rootNamespace;

    public function __construct(string $relativePath, string $rootNamespace = 'App', int $offset = 0)
    {
        [$this->relativePath, $this->offsetPath] = $this->extractPaths($relativePath, abs($offset));
        $this->rootNamespace = $rootNamespace;
    }

    public function normalizedValue(): string
    {
        return $this->relativePath;
    }

    public function normalizedOffsetValue(): string
    {
        return $this->offsetPath;
    }

    public function toNamespace(string $suffixNamespace = ''): string
    {
        return $this->rootNamespace.'\\'.str_replace('/', '\\', $this->relativePath).$suffixNamespace;
    }

    public function toNamespaceOffset(string $suffixNamespace = ''): string
    {
        return $this->rootNamespace.'\\'.str_replace('/', '\\', $this->relativePath).'\\'.$this->offsetPath.$suffixNamespace;
    }

    public function toShortClassName(): string
    {
        if ('' !== $this->offsetPath) {
            if (false === $position = strrpos($this->offsetPath, '/')) {
                return $this->offsetPath;
            }

            return substr($this->offsetPath, $position + 1);
        }

        if (false === $position = strrpos($this->relativePath, '/')) {
            return $this->relativePath;
        }

        return substr($this->relativePath, $position + 1);
    }

    private function extractPaths(string $relativePath, int $offset): array
    {
        $normalized = str_replace('-', '', ucwords(trim($relativePath, '/'), '/-'));
        $offsetPath = [];

        while ($offset > 0 && false !== $position = strrpos($normalized, '/')) {
            array_unshift($offsetPath, substr($normalized, $position + 1));
            $normalized = substr($normalized, 0, $position);
            --$offset;
        }

        return [$normalized, implode('/', $offsetPath)];
    }
}
