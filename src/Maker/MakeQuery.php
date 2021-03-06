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
use Yceruto\DddMakerBundle\Generator\CQGenerator;

final class MakeQuery extends AbstractMaker
{
    private CQGenerator $commandGenerator;

    public function __construct(CQGenerator $commandGenerator)
    {
        $this->commandGenerator = $commandGenerator;
    }

    public static function getCommandName(): string
    {
        return 'make:cqs:query';
    }

    public static function getCommandDescription(): string
    {
        return 'Creates a new Query';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command
            ->addArgument('path', InputArgument::REQUIRED, 'The namespace path of the new Query (e.g. <fg=yellow>catalog/listing</>)')
            ->addArgument('name', InputArgument::REQUIRED, 'The Query name (e.g. <fg=yellow>find</>)')
            //->setHelp(file_get_contents(__DIR__.'/../help/MakeCommand.txt'))
        ;
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $io->title('Creating new Query');
        $path = $input->getArgument('path');
        $name = $input->getArgument('name');

        $this->commandGenerator->generateQuery($path, $name);

        $this->writeSuccessMessage($io);
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
        // no-op
    }
}
