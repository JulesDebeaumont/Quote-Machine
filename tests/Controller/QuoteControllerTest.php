<?php
declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QuoteControllerTest extends WebTestCase
{
    public function testListQuotes()
    {
        $client = static::createClient();
        $client->restart();
        $client->followRedirects();

        $client ->request('GET', '/');

        $client->clickLink('Connexion');
        $this->assertResponseIsSuccessful();

        $client->submitForm('Se connecter', [
            'email' => 'random@outlook.fr',
            'password' => 'iutinfo',
        ]);


        $client->clickLink('Ajouter une quote');
        $this->assertResponseIsSuccessful();

        $client->submitForm('Enregistrer !', [
            'La quote' => 'La quote du test',
            'La source' => 'La source du test',
        ]);

        $this->assertSelectorTextContains('h1', 'Liste des citations');
        $this->assertSelectorTextContains('ul', 'La quote du test');
        $this->assertSelectorTextContains('ul', 'La source du test');
    }
}
