<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Finder\Finder;

class AppFixtures extends Fixture
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;


    }

    public function load(ObjectManager $manager): void
    {
        $finder = new Finder();
        $finder->in("data");
        $finder->files();

        foreach ($finder as $file) {
            $sql = $file->getContents();
            $this->entityManager->getConnection()->executeQuery($sql);

        }

    }
}
