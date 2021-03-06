<?php
declare(strict_types=1);

namespace DR\GitCommitNotification\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/**
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
class AbstractTest extends TestCase
{
    use TestTrait;

    /** @var MockObject|LoggerInterface */
    protected LoggerInterface $log;

    protected function setUp(): void
    {
        $this->log = $this->createMock(LoggerInterface::class);
    }
}
