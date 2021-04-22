<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    /*
    public function testCategory()
    {
        $category = new Category();
        $category->setName('Comics');

        self::$container->get('doctrine')->getManagerForClass(Category::class)->persist($category);
        self::$container->get('doctrine')->getManagerForClass(Category::class)->flush(); //methode

        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin@outlook.fr',
            'PHP_AUTH_PW' => 'iutinfo',
        ]);

        $client->request('GET', '/category/');

        $this->assertSelectorTextContains('.content', 'Comics');
    }
    */
}
