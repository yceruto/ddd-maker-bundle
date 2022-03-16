<?php

/*
 * This file is part of the DddBundle package.
 *
 * (c) Yonel Ceruto <yonelceruto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yceruto\DddMakerBundle\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

final class MakeAppContext extends AbstractMaker
{
    private string $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public static function getCommandName(): string
    {
        return 'make:ddd:context';
    }

    public static function getCommandDescription(): string
    {
        return 'Creates a new Kernel context (Application)';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command
            ->addArgument('context', InputArgument::REQUIRED, 'The new Kernel context (e.g. <fg=yellow>BoundedContextName</>)')
            //->setHelp(file_get_contents(__DIR__.'/../help/MakeAppContext.txt'))
        ;
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $context = ucfirst($input->getArgument('context'));
        $contextLower = strtolower($context);
        $skeletonDir = dirname(__DIR__, 2).'/config/skeleton';
        $io->title('Creating new Kernel context (Application)');

        $generator->generateFile(
            $this->projectDir.'/context/'.$contextLower.'/config/bundles.php',
            $skeletonDir.'/context/config/bundles.tpl.php'
        );

        $generator->generateFile(
            $this->projectDir.'/context/'.$contextLower.'/config/routes.yaml',
            $skeletonDir.'/context/config/routes.tpl.php',
            ['context' => $context]
        );

        $generator->generateFile(
            $this->projectDir.'/context/'.$contextLower.'/config/services.yaml',
            $skeletonDir.'/context/config/services.tpl.php',
            ['context' => $context]
        );

        $generator->generateFile(
            $this->projectDir.'/context/'.$contextLower.'/src/Controller/.gitignore',
            $skeletonDir.'/.gitignore'
        );

        $generator->generateFile(
            $this->projectDir.'/tests/context/'.$contextLower.'/'.$context.'WebTestCase.php',
            $skeletonDir.'/context/tests/WebTestCase.tpl.php',
            ['context' => $context, 'contextLower' => $contextLower]
        );

        $generator->writeChanges();

        if (is_file($this->projectDir.'/composer.json') && is_readable($this->projectDir.'/composer.json')) {
            $composerJson = json_decode(file_get_contents($this->projectDir.'/composer.json'), true);
            $composerJson['autoload']['psr-4'][$context.'\\'] = 'context/'.$contextLower.'/src/';
            $composerJson['autoload-dev']['psr-4'][$context.'\\Tests\\'] = 'tests/context/'.$contextLower.'/';
            file_put_contents($this->projectDir.'/composer.json', json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)."\n");
        }
        $io->comment('<fg=yellow>updated</>: composer.json (<comment>composer dump-autoload</> required)');

        $this->writeSuccessMessage($io);
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
        // no-op
    }
}
