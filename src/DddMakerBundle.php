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

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DddMakerBundle extends Bundle
{
    public function getPath(): string
    {
        return dirname(__DIR__);
    }
}
