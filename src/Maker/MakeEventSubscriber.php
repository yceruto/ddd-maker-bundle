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
            ->addArgument('path', InputArgument::REQUIRED, 'The relative path of the new Domain Event Subscriber (e.g. <fg=yellow>catalog/listing/send-listing-published-email</>)')
            ->addArgument('event', InputArgument::REQUIRED, 'The event name (e.g. <fg=yellow>published</>)')
            //->setHelp(file_get_contents(__DIR__.'/../help/MakeCommand.txt'))
        ;
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $io->title('Creating new Domain Event Subscriber');
        $path = $input->getArgument('path');
        $eventName = $input->getArgument('event');

        $this->eventGenerator->generateEventSubscriber($path, $eventName);

        $this->writeSuccessMessage($io);
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
        // no-op
    }
}
