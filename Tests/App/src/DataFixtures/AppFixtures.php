<?php
namespace Kna\HalBundle\Tests\App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Kna\HalBundle\Tests\App\Entity\Hero;

class AppFixtures extends Fixture
{
    public $heroes = [
        ['name' => 'Iron Man', 'ability' => 'money'],
        ['name' => 'Black Widow', 'ability' => 'none'],
        ['name' => 'Wolverine', 'ability' => 'regeneration'],
        ['name' => 'Deadpool', 'ability' => 'regeneration'],
        ['name' => 'Jessica Campbell Jones Cage', 'ability' => 'power'],
        ['name' => 'Domino', 'ability' => 'luck'],

    ];

    public function load(ObjectManager $manager)
    {
        foreach ($this->heroes as $heroData) {
            $hero = new Hero();
            $hero->setName($heroData['name']);
            $hero->setAbility($heroData['ability']);
            $manager->persist($hero);
        }

        $manager->flush();
    }
}