<?php

namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class UserFixture extends BaseFixture
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function(int $count) {
            $user = new User();
            $user->setEmail(sprintf('spacebar%d@example.com', $count));
            $user->setFirstName($this->faker->firstName);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user, 
                '12345678'
            ));

            return $user;
        });

        $this->createMany(3, 'admin_users', function(int $count) {
            $user = new User();
            $user->setEmail(sprintf('admin%d@example.com', $count));
            $user->setFirstName($this->faker->firstName);
            $user->setRoles(['ROLE_ADMIN']);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user, 
                '12345678'
            ));

            return $user;
        });

        $manager->flush();
    }
}
