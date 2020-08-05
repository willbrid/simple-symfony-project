<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use App\Entity\Tag;

class TagFixtures extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_tags', function(int $count) {
            $tag = new Tag(); 
            $tag->setName($this->faker->realText(20));

            return $tag;
        });

        $manager->flush();
    }
}
