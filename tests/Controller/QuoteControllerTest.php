<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuoteControllerTest extends WebTestCase
{
    public function authAsAdmin(): \Symfony\Bundle\FrameworkBundle\KernelBrowser
    {
        return $client = static::createClient([], [
            'PHP_AUTH_USER' => 'admin@outlook.fr',
            'PHP_AUTH_PW' => 'iutinfo',
        ]);
    }

    public function createQuote($client)
    {
        $client->request('GET', '/quotes/ajouter');

        $client->submitForm('Enregistrer !', [
            'quote_modify_form[content]' => 'La quote du test',
            'quote_modify_form[meta]' => 'La source du test',
        ]);
    }

    public function clientGoToHomePage($client)
    {
        $client->request('GET', '/');
        $client->followRedirect();
    }

    public function testQuoteIsCreated()
    {
        $client = $this->authAsAdmin();

        $this->createQuote($client);

        $this->clientGoToHomePage($client);

        //echo $client->getResponse()->getContent();

        $this->assertSelectorTextContains('h1', 'Liste des citations');
        $this->assertSelectorTextContains('.content', 'La quote du test');
        $this->assertSelectorTextContains('.meta', 'La source du test');
    }

    public function testQuoteModify()
    {
        $client = $this->authAsAdmin();

        $this->createQuote($client);

        $this->clientGoToHomePage($client);

        $client->clickLink('Modifier');
        $this->assertResponseIsSuccessful();

        $client->submitForm('Enregistrer !', [
            'quote_modify_form[content]' => 'Content modifié !',
            'quote_modify_form[meta]' => 'Meta modifié !',
        ]);
        $client->followRedirect();

        $this->assertSelectorTextContains('h1', 'Liste des citations');
        $this->assertSelectorTextContains('.content', 'Content modifié !');
        $this->assertSelectorTextContains('.meta', 'Meta modifié !');
    }

    public function testQuoteDelete()
    {
        $client = $this->authAsAdmin();

        $this->createQuote($client);

        $this->clientGoToHomePage($client);

        $client->clickLink('Supprimer');
        $client->followRedirect();

        $this->assertSelectorTextContains('h1', 'Liste des citations');
        $this->assertSelectorTextNotContains('body', 'Content modifié !');
        $this->assertSelectorTextNotContains('body', 'Meta modifié !');
    }
}
