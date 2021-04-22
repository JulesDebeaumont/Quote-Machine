<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuoteControllerTest extends WebTestCase
{
    public function testListQuotes()
    {
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'random@outlook.fr',
            'PHP_AUTH_PW' => 'iutinfo',
        ]);
        $client->restart();

        $client->request('GET', '/');
        $client->followRedirect();

        //Création
        $client->clickLink('Ajouter une quote');
        $this->assertResponseIsSuccessful();

        $client->submitForm('Enregistrer !', [
            'quote_modify_form[content]' => 'La quote du test',
            'quote_modify_form[meta]' => 'La source du test',
        ]);
        $client->followRedirect();

        //echo $client->getResponse()->getContent();

        $this->assertSelectorTextContains('h1', 'Liste des citations');
        $this->assertSelectorTextContains('.content', 'La quote du test');
        $this->assertSelectorTextContains('.meta', 'La source du test');

        //Modification
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

        //Suppression
        $client->clickLink('Supprimer');
        $client->followRedirect();

        $this->assertSelectorTextContains('h1', 'Liste des citations');
        $this->assertSelectorTextNotContains('body', 'Content modifié !');
        $this->assertSelectorTextNotContains('body', 'Meta modifié !');
    }
}
