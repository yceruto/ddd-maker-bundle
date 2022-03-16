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
use Symfony\Component\Console\Input\InputOption;
use Yceruto\DddMakerBundle\Generator\CQGenerator;

final class MakeCommand extends AbstractMaker
{
    private CQGenerator $commandGenerator;

    public function __construct(CQGenerator $commandGenerator)
    {
        $this->commandGenerator = $commandGenerator;
    }

    public static function getCommandName(): string
    {
        return 'make:cqs:command';
    }

    public static function getCommandDescription(): string
    {
        return 'Creates a new Command';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command
            ->addArgument('path', InputArgument::REQUIRED, 'The relative path of the new Command (e.g. <fg=yellow>catalog/listing/publish</>)')
            ->addOption('factory', null, InputOption::VALUE_NONE, 'Generate with factory')
            //->setHelp(file_get_contents(__DIR__.'/../help/MakeCommand.txt'))
        ;
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $io->title('Creating new Command');
        $path = $input->getArgument('path');
        $factory = $input->getOption('factory');

        $this->commandGenerator->generateCommand($path, $factory);

        $this->writeSuccessMessage($io);
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
        // no-op
    }
}
