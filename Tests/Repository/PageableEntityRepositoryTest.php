<?php
namespace Kna\HalBundle\Tests\Repository;


use Kna\HalBundle\Repository\PageableEntityRepository;
use PHPUnit\Framework\TestCase;

class PageableEntityRepositoryTest extends TestCase
{
    public function testGetAlias_DefaultValue_EqualsE()
    {
        $repo = $this->getMockBuilder(PageableEntityRepository::class)->disableOriginalConstructor()->getMockForAbstractClass();
        $this->assertEquals('e', $repo->getAlias());
    }
}