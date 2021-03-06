<?php
declare(strict_types=1);

namespace DR\GitCommitNotification\Service\Git\Diff;

use DR\GitCommitNotification\Service\Git\GitCommandBuilderInterface;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class GitDiffCommandBuilder implements GitCommandBuilderInterface
{
    private string $git;

    /** @var array<string, string> */
    private array $arguments = [];

    public function __construct(string $git)
    {
        $this->git = $git;
    }

    public function start(): self
    {
        $this->arguments            = [];
        $this->arguments['app']     = $this->git;
        $this->arguments['command'] = 'diff';

        return $this;
    }

    public function hashes(string $fromHash, string $toHash): self
    {
        $this->arguments['fromHash'] = $fromHash;
        $this->arguments['toHash']   = $toHash;

        return $this;
    }

    public function ignoreCrAtEol(): self
    {
        $this->arguments['ignore-cr-at-eol'] = '--ignore-cr-at-eol';

        return $this;
    }

    public function ignoreSpaceAtEol(): self
    {
        $this->arguments['ignore-space-at-eol'] = '--ignore-space-at-eol';

        return $this;
    }

    public function ignoreSpaceChange(): self
    {
        $this->arguments['ignore-space-change'] = '--ignore-space-change';

        return $this;
    }

    public function ignoreAllSpace(): self
    {
        $this->arguments['ignore-all-space'] = '--ignore-all-space';

        return $this;
    }

    public function ignoreBlankLines(): self
    {
        $this->arguments['ignore-blank-lines'] = '--ignore-blank-lines';

        return $this;
    }

    public function diffAlgorithm(string $algorithm = 'histogram'): self
    {
        $this->arguments['diff-algorithm'] = sprintf('--diff-algorithm="%s"', $algorithm);

        return $this;
    }

    /**
     * @return string[]
     */
    public function build(): array
    {
        return array_values($this->arguments);
    }

    public function __toString(): string
    {
        return implode(" ", $this->arguments);
    }
}
