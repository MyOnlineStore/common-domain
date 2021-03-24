<?php
declare(strict_types=1);

namespace MyOnlineStore\Common\Domain\Tests\Benchmark\Value\Web;

use MyOnlineStore\Common\Domain\Value\Web\DomainName;
use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\Revs;

/**
 * @BeforeMethods({"init"})
 */
final class DomainNameBench
{
    /** @var DomainName */
    private $domainName;

    /** @var DomainName */
    private $comparator;

    public function init(): void
    {
        $this->domainName = new DomainName('foo.bar');
        $this->comparator = new DomainName('bar.foo');
    }

    /**
     * @Revs(10000)
     * @Iterations(5)
     */
    public function benchConstruction(): void
    {
        new DomainName('foo.bar');
    }

    /**
     * @Revs(10000)
     * @Iterations(5)
     */
    public function benchEquals(): void
    {
        $this->domainName->equals($this->comparator);
    }

    /**
     * @Revs(10000)
     * @Iterations(5)
     */
    public function benchStringCast(): void
    {
        (string) $this->domainName;
    }
}
