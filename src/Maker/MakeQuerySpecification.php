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
use Yceruto\DddMakerBundle\Generator\DddQuerySpecificationGenerator;

final class MakeQuerySpecification extends AbstractMaker
{
    private DddQuerySpecificationGenerator $querySpecGenerator;

    public function __construct(DddQuerySpecificationGenerator $querySpecGenerator)
    {
        $this->querySpecGenerator = $querySpecGenerator;
    }

    public static function getCommandName(): string
    {
        return 'make:ddd:query-specification';
    }

    public static function getCommandDescription(): string
    {
        return 'Creates a new Query Specification';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command
            ->addArgument('path', InputArgument::REQUIRED, 'The namespace path of the new Query Specification (e.g. <fg=yellow>catalog/listing</>)')
            ->addArgument('name', InputArgument::REQUIRED, 'The Query Specification name (e.g. <fg=yellow>find-by-title</>)')
            //->setHelp(file_get_contents(__DIR__.'/../help/MakeCommand.txt'))
        ;
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $io->title('Creating new Query Specification');
        $path = $input->getArgument('path');
        $name = $input->getArgument('name');

        $this->querySpecGenerator->generateQuerySpecification($path, $name);

        $this->writeSuccessMessage($io);
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
        // no-op
    }
}
