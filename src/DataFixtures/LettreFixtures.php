<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Lettre;

class LettreFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       for($i=1;$i<=4;$i++){
           $lettre=new Lettre();
           $lettre->setNom("enfant $i")
                ->setAdresse("ville$i")
                ->setAge("$i")
                ->setTextlettre("la lettre est ecrite par $i")
                ->setImagelettre("http://placehold.it/350x350");
            $manager->persist($lettre);
}

        $manager->flush();
    }
}
