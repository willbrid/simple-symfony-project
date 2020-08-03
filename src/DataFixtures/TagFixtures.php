<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use App\Entity\Tag;

class TagFixtures extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Tag::class, 10, function(Tag $tag, $count) {
            $tag->setName($this->faker->realText(20));
        });

        $manager->flush();
    }
}
