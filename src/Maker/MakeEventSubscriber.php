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
use Yceruto\DddMakerBundle\Generator\DddEventGenerator;

final class MakeEventSubscriber extends AbstractMaker
{
    private DddEventGenerator $eventGenerator;

    public function __construct(DddEventGenerator $eventGenerator)
    {
        $this->eventGenerator = $eventGenerator;
    }

    public static function getCommandName(): string
    {
        return 'make:ddd:event-subscriber';
    }

    public static function getCommandDescription(): string
    {
        return 'Creates a new Domain Event Subscriber';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command
            ->addArgument('path', InputArgument::REQUIRED, 'The namespace path of the new Domain Event Subscriber (e.g. <fg=yellow>catalog/listing</>)')
            ->addArgument('name', InputArgument::REQUIRED, 'The Subscriber name (e.g. <fg=yellow>send-listing-published-email</>)')
            ->addArgument('event', InputArgument::REQUIRED, 'The Domain Event path/name (e.g. <fg=yellow>published</> or <fg=yellow>catalog/listing/published</>)')
            //->setHelp(file_get_contents(__DIR__.'/../help/MakeCommand.txt'))
        ;
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $io->title('Creating new Domain Event Subscriber');
        $path = $input->getArgument('path');
        $name = $input->getArgument('name');
        $event = $input->getArgument('event');

        $eventPath = null;
        if (false !== $position = strrpos($event, '/')) {
            $eventPath = substr($event, 0, $position);
            $event = substr($event, $position + 1);
        }

        $this->eventGenerator->generateEventSubscriber($path, $name, $event, $eventPath);

        $this->writeSuccessMessage($io);
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
        // no-op
    }
}
