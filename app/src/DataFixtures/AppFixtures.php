<?php
namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        // Create a mock user
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password123'));
        $manager->persist($user);

        // Create mock cars
        $car1 = new Car();
        $car1->setMake('Toyota');
        $car1->setModel('Camry');
        $car1->setYear('2020');
        $manager->persist($car1);

        $car2 = new Car();
        $car2->setMake('Honda');
        $car2->setModel('Civic');
        $car2->setYear('2019');
        $manager->persist($car2);

        $manager->flush();
    }
}
