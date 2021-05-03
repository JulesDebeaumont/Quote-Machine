<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testCategory()
    {
        /*
        $manager = self::$container->get('doctrine')->getManagerForClass(Category::class);

        $category = new Category();
        $category->setName('Comics');

        $manager->persist($category);
        $manager->flush();

        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin@outlook.fr',
            'PHP_AUTH_PW' => 'iutinfo',
        ]);

        $client->request('GET', '/category/');

        $this->assertSelectorTextContains('.content', 'Comics');

        //Check dans la BD s'il existe
        $manager->getRepository(Category::class)->findOneBy(['name' => 'Comics']);
        */
    }
}
