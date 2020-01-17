<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Service\UserService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;


class UserFixture extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserFixture constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserService $userService
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, UserService $userService)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->userService = $userService;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
  
            $admin = new User;
            $admin
                ->setEmail("admin@cinesuper.com")
                ->setPassword($this->passwordEncoder->encodePassword($admin, "12345678"))
                ->setFirstName("David")
                ->setLastName("Hasselhoff")
                ->setEnabled(1)
                ->setRoles(["ROLE_ADMIN"])
                ->setBirthdate(new \Datetime('now'))
                ->setCard($this->userService->generateCard($admin));

            $cashier = new User;
            $cashier
                ->setEmail("jeanine@cinesuper.com")
                ->setPassword($this->passwordEncoder->encodePassword($cashier, "12345678"))
                ->setFirstName("Jeanine")
                ->setLastName("Duval")
                ->setEnabled(1)
                ->setRoles(["ROLE_CASHIER"])
                ->setBirthdate(new \Datetime('now'))
                ->setCard($this->userService->generateCard($cashier));

        $manager->persist($admin);
        $manager->persist($cashier);
        $manager->flush();
    }
}
