<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Conference;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\Lorem;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i <= 10; $i++) {
            $conference = new Conference();

            $conference->setCity($faker->country)
                ->setYear($faker->year())
                ->setIsInternational($faker->boolean());

            for ($j = 0; $j <= mt_rand(0, 3); $j++) {
                $comment = new Comment();

                $di = new DateTimeImmutable("2018-12-12T10:00:00");

                $comment->setAuthor($faker->name)
                    ->setText($faker->words(20, true))
                    ->setEmail($faker->email)
                    ->setCreatedAt($di)
                    ->setPhotoFilename($faker->imageUrl(200, 200))
                    ->setConference($conference);
                $manager->persist($comment);
            }

            $manager->persist($conference);
        }

        $manager->flush();
    }
}
