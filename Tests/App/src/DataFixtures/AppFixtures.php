<?php
namespace Kna\HalBundle\Tests\App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Kna\HalBundle\Tests\App\Entity\Hero;

class AppFixtures extends Fixture
{
    public $heroes = [
        ['name' => 'Iron Man'],
        ['name' => 'Black Widow'],
        ['name' => 'Wolverine'],
        ['name' => 'Deadpool'],
        ['name' => 'Jessica Campbell Jones Cage'],
        ['name' => 'Domino'],

    ];
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->heroes as $heroData) {
            $hero = new Hero();
            $hero->setName($heroData['name']);
            $manager->persist($hero);
        }

        $manager->flush();
    }
}