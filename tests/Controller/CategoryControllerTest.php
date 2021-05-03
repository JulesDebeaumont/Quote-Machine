<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function makeComicsCategory()
    {
        $manager = self::$container->get('doctrine')->getManagerForClass(Category::class);

        $category = new Category();
        $category->setName('Comics');

        $manager->persist($category);
        $manager->flush();
    }

    public function authAsAdmin(): \Symfony\Bundle\FrameworkBundle\KernelBrowser
    {
        return $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin@outlook.fr',
            'PHP_AUTH_PW' => 'iutinfo',
        ]);
    }

    public function authAsRegularUser(): \Symfony\Bundle\FrameworkBundle\KernelBrowser
    {
        return $client = static::createClient([], [
            'PHP_AUTH_USER' => 'random@outlook.fr',
            'PHP_AUTH_PW' => 'iutinfo',
        ]);
    }

    public function testCategoryCreate()
    {
        $client = $this->authAsAdmin();

        $this->makeComicsCategory();

        $manager = self::$container->get('doctrine')->getManagerForClass(Category::class);
        $comics = $manager->getRepository(Category::class)->findOneBy(['name' => 'Comics']);

        //Check dans la BD s'il existe la new catégorie
        $this->assertSame('Comics', $comics->getName());

        $client->request('GET', '/category/');

        //echo $client->getResponse()->getContent();

        $this->assertSelectorTextContains('.content', 'Comics');
    }

    public function testCategoryModify()
    {
        $client = $this->authAsAdmin();

        $this->makeComicsCategory();

        $manager = self::$container->get('doctrine')->getManagerForClass(Category::class);
    }

    /*
        public function testCategoryModifyAsNotAdmin()
        {
            $client = $this->authAsRegularUser();

        }

        public function testCategoryDelete()
        {
            $client = static::createClient([], [
                'PHP_AUTH_USER' => 'admin@outlook.fr',
                'PHP_AUTH_PW' => 'iutinfo',
            ]);
        }
    */
}
