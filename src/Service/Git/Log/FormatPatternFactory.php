<?php
declare(strict_types=1);

namespace DR\GitCommitNotification\Service\Git\Log;

use DR\GitCommitNotification\Git\FormatPattern;

/**
 * Factory for creation Git log --format pattern that's parseable by GitLogParser.
 */
class FormatPatternFactory
{
    public const PATTERN          = [
        FormatPattern::PARENT_HASH,
        FormatPattern::COMMIT_HASH,
        FormatPattern::AUTHOR_NAME,
        FormatPattern::AUTHOR_EMAIL,
        FormatPattern::AUTHOR_DATE_ISO8601,
        FormatPattern::SUBJECT,
        FormatPattern::REF_NAMES
    ];
    // intentionally two-part string to avoid this commit to match output
    public const PARTS_DELIMITER  = '~' . '~&>8~#@~8<&~';
    public const COMMIT_DELIMITER = '~' . '!---------------------- >8~ ----------------------!~';

    public function createPattern(): string
    {
        return self::COMMIT_DELIMITER . implode(self::PARTS_DELIMITER, self::PATTERN) . self::PARTS_DELIMITER;
    }
}
