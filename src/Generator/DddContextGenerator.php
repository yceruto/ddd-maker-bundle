<?php

/*
 * This file is part of the DddBundle package.
 *
 * (c) Yonel Ceruto <yonelceruto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yceruto\DddMakerBundle\Generator;

use Symfony\Bundle\MakerBundle\Generator;

class DddContextGenerator
{
    private Generator $generator;
    private string $projectDir;
    private string $skeletonDir;

    public function __construct(Generator $generator, string $projectDir, string $skeletonDir)
    {
        $this->generator = $generator;
        $this->projectDir = $projectDir;
        $this->skeletonDir = $skeletonDir;
    }

    public function generateContext(string $context): void
    {
        $contextLower = strtolower($context);

        $this->generator->generateFile(
            $this->projectDir.'/context/'.$contextLower.'/config/bundles.php',
            $this->skeletonDir.'/context/config/bundles.tpl.php'
        );

        $this->generator->generateFile(
            $this->projectDir.'/context/'.$contextLower.'/config/routes.yaml',
            $this->skeletonDir.'/context/config/routes.tpl.php',
            ['context' => $context]
        );

        $this->generator->generateFile(
            $this->projectDir.'/context/'.$contextLower.'/config/services.yaml',
            $this->skeletonDir.'/context/config/services.tpl.php',
            ['context' => $context]
        );

        $this->generator->generateFile(
            $this->projectDir.'/context/'.$contextLower.'/src/Controller/.gitignore',
            $this->skeletonDir.'/.gitignore'
        );

        $this->generator->generateFile(
            $this->projectDir.'/tests/context/'.$contextLower.'/'.$context.'WebTestCase.php',
            $this->skeletonDir.'/context/tests/WebTestCase.tpl.php',
            ['context' => $context, 'contextLower' => $contextLower]
        );

        $this->generator->writeChanges();
    }
}
