<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Comment;
use App\Entity\Article;

class CommentFixture extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(100, 'main_comments', function(int $count) {
            $comment = new Comment();  
            $comment->setContent(
                $this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true)
            );
            $comment->setAuthorName($this->faker->name);
            $comment->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'));
            $comment->setArticle($this->getRandomReference('main_articles'));
            $comment->setIsDeleted($this->faker->boolean(20));

            return $comment;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ArticleFixture::class
        ];
    }
}
