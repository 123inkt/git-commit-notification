<?php
declare(strict_types=1);

namespace DR\GitCommitNotification\Command\ExternalLink;

use DigitalRevolution\SymfonyConsoleValidation\Exception\ViolationException;
use DigitalRevolution\SymfonyConsoleValidation\InputValidator;
use DigitalRevolution\SymfonyValidationShorthand\Rule\InvalidRuleException;
use Doctrine\Persistence\ManagerRegistry;
use DR\GitCommitNotification\Entity\ExternalLink;
use DR\GitCommitNotification\Input\AddExternalLinkInput;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('external-link:add', 'Add a matching pattern to urlify a part of a commit message')]
class AddExternalLinkCommand extends Command
{
    public function __construct(private ManagerRegistry $doctrine, private InputValidator $inputValidator, ?string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addArgument('pattern', InputArgument::REQUIRED, 'The pattern to match in the commit message. For example `T#{}`');
        $this->addArgument('url', InputArgument::REQUIRED, 'The url to apply the match to. For example: `http://jira.atlassian.com/task/{}`');
    }

    /**
     * @throws ViolationException|InvalidRuleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $validatedInput = $this->inputValidator->validate($input, AddExternalLinkInput::class);

        // create link
        $externalLink = new ExternalLink();
        $externalLink->setPattern($validatedInput->getPattern());
        $externalLink->setUrl($validatedInput->getUrl());

        // persist
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($externalLink);
        $entityManager->flush();

        $output->writeln(sprintf('<info>Successfully added external link: `%s`-`%s</info>', $externalLink->getPattern(), $externalLink->getUrl()));

        return Command::SUCCESS;
    }
}
