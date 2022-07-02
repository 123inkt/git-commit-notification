<?php
declare(strict_types=1);

namespace DR\GitCommitNotification\Tests\Unit\Repository\Config;

use DR\GitCommitNotification\Entity\Config\ExternalLink;
use DR\GitCommitNotification\Repository\Config\ExternalLinkRepository;
use DR\GitCommitNotification\Tests\AbstractRepositoryTestCase;

/**
 * @implements ExternalLinkRepository
 * @coversDefaultClass \DR\GitCommitNotification\Repository\Config\ExternalLinkRepository
 * @covers ::__construct
 */
class ExternalLinkRepositoryTest extends AbstractRepositoryTestCase
{
    /**
     * @covers ::add
     */
    public function testAdd(): void
    {
        $link = new ExternalLink();

        $this->expectPersist($link);
        $this->expectFlush();
        $this->repository->add($link, true);
    }

    /**
     * @covers ::remove
     */
    public function testRemove(): void
    {
        $link = new ExternalLink();

        $this->expectRemove($link);
        $this->expectFlush();
        $this->repository->remove($link, true);
    }

    public function getRepositoryClass(): string
    {
        return ExternalLinkRepository::class;
    }
}