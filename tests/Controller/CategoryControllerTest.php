<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    public function getCategory(string $name): Category
    {
        return $this->getRepository()->findOneBy(['name' => $name]);
    }

    public function getRepository(): CategoryRepository
    {
        return self::$container->get('doctrine')->getRepository(Category::class);
    }

    public function getManager(): EntityManagerInterface
    {
        return self::$container->get('doctrine')->getManagerForClass(Category::class);
    }

    public function testCategoryCreate()
    {
        $client = $this->authAsAdmin();

        $client->request('GET', '/category/new');

        $client->submitForm('Enregistrer', [
            'category[name]' => 'Comics',
        ]);
        $client->followRedirect();

        $comics = $this->getCategory('Comics');
        $this->assertSame('Comics', $comics->getName());

        $this->assertSelectorTextContains('.content', 'Comics');
    }

    public function testCategoryModify()
    {
        $client = $this->authAsAdmin();

        $this->makeComicsCategory();

        $client->request('GET', '/category/');

        $client->clickLink('Modifier');

        $comics = $this->getCategory('Comics');
        $idComics = $comics->getId();

        $client->submitForm('Enregistrer', [
            'category[name]' => 'Rick & Morty',
        ]);
        $client->followRedirect();

        $rick = $this->getRepository()->findOneBy(['id' => $idComics]);
        $this->assertSame('Rick & Morty', $rick->getName());

        $client->request('GET', '/category/');
        $this->assertSelectorTextContains('.content', 'Rick & Morty');
    }

    public function testCategoryDeleteAsAdmin()
    {
        $client = $this->authAsAdmin();

        $this->makeComicsCategory();

        $client->request('GET', '/category/');

        $client->submitForm('Delete', []);
        $client->followRedirect();

        $this->assertSelectorTextNotContains('body', 'Comics');

        $this->assertCount(0,
            self::$container->
            get('doctrine')->
            getRepository(Category::class)->
            findAll());
    }

    public function testCategoryDeleteAsRegularUser()
    {
        $client = $this->authAsRegularUser();

        $this->makeComicsCategory();

        $comics = $this->getCategory('Comics');
        $slugComics = $comics->getSlug();

        $client->request('GET', '/category/');

        $this->assertSelectorTextNotContains('body', 'Delete');
        $client->request('DELETE', '/category/'.$slugComics);

        $this->assertResponseStatusCodeSame(403);
    }
}
