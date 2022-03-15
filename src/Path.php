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
    private string $rootNamespace;

    public function __construct(string $relativePath, string $rootNamespace = 'App')
    {
        $this->relativePath = ucwords(strtolower(trim($relativePath, '/')), '/');
        $this->rootNamespace = $rootNamespace;
    }

    public function normalizedValue(): string
    {
        return $this->relativePath;
    }

    public function toNamespace(string $suffixNamespace = ''): string
    {
        return $this->rootNamespace.'\\'.str_replace('/', '\\', $this->relativePath).$suffixNamespace;
    }

    public function toShortClassName(): string
    {
        if (false === $position = strrpos($this->relativePath, '/')) {
            return $this->relativePath;
        }

        return substr($this->relativePath, $position + 1);
    }
}
