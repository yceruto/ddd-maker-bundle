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
use Yceruto\DddMakerBundle\Generator\DddContextGenerator;

final class MakeContext extends AbstractMaker
{
    private DddContextGenerator $contextGenerator;
    private string $projectDir;

    public function __construct(DddContextGenerator $contextGenerator, string $projectDir)
    {
        $this->contextGenerator = $contextGenerator;
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
            ->addArgument('context', InputArgument::REQUIRED, 'The new Kernel context (e.g. <fg=yellow>Admin</>)')
            //->setHelp(file_get_contents(__DIR__.'/../help/MakeAppContext.txt'))
        ;
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $context = ucfirst($input->getArgument('context'));
        $contextLower = strtolower($context);

        $io->title('Creating new Kernel context (Application)');
        $this->contextGenerator->generateContext($context);

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
