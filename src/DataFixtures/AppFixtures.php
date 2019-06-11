<?php

namespace App\DataFixtures;

use App\Entity\Business;
use App\Entity\User;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * The app fixtures.
 *
 * @package App\DataFixtures
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 */
class AppFixtures extends Fixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $entityManager)
    {
        $owner = new Business(
            'BileMo' // Name
        );
        $entityManager->persist($owner);

        $admin = new User(
            'example@example.com', // Username
            $owner                 // Business
        );
        $entityManager->persist($admin);

        for ($i = 0; $i < 10; $i++) {
            $product = new Product(
                \str_repeat((string)$i, 14), // GTIN 14
                (float)'1024.16',            // Price
                'USD'                        // Currency
            );
            $entityManager->persist($product);
        }

        $entityManager->flush();
    }
}
