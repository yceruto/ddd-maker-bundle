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
use Yceruto\DddMakerBundle\Generator\DddModuleGenerator;

final class MakeModule extends AbstractMaker
{
    private DddModuleGenerator $moduleGenerator;

    public function __construct(DddModuleGenerator $moduleGenerator)
    {
        $this->moduleGenerator = $moduleGenerator;
    }

    public static function getCommandName(): string
    {
        return 'make:ddd:module';
    }

    public static function getCommandDescription(): string
    {
        return 'Creates a new Module';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command
            ->addArgument('path', InputArgument::REQUIRED, 'The namespace path of the new Module (e.g. <fg=yellow>catalog/listing</>)')
            ->addOption('basic', null, InputOption::VALUE_NONE, 'Generate only the basic module structure')
            ->addOption('spec', null, InputOption::VALUE_NONE, 'Generate with Specification')
            //->setHelp(file_get_contents(__DIR__.'/../help/MakeModule.txt'))
        ;
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $io->title('Creating new Module');
        $path = $input->getArgument('path');

        if ($input->getOption('basic')) {
            $this->moduleGenerator->generateBasic($path);

            return;
        }

        $this->moduleGenerator->generateFull($path, $input->getOption('spec'));

        $this->writeSuccessMessage($io);
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
        // no-op
    }
}
