<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Benchmark\Value;

use MyOnlineStore\Common\Domain\Value\Locale;
use PhpBench\Benchmark\Metadata\Annotations\BeforeMethods;
use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\Revs;

/**
 * @BeforeMethods({"init"})
 */
final class LocaleBench
{
    private Locale $locale;
    private Locale $other;

    public function init(): void
    {
        $this->locale = Locale::fromString('nl_NL');
        $this->other = Locale::fromString('en_GB');
    }

    /**
     * @Revs(10000)
     * @Iterations(5)
     */
    public function benchEquals(): void
    {
        $this->locale->equals($this->other);
    }
}
