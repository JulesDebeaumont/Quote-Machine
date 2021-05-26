<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testMailWhenRegister()
    {
        $client = static::createClient();
        $client->request('GET', '/register');

        $client->submitForm("S'enregistrer", [
            'registration_form[email]' => 'mailTest@random.fr',
            'registration_form[name]' => 'Test',
            'registration_form[plainPassword]' => 'Iutinfo51',
            'registration_form[agreeTerms]' => 1,
        ]);

        $this->assertEmailCount(1);

        $email = $this->getMailerMessage(0);
        $this->assertEmailHeaderSame($email, 'To', 'mailTest@random.fr');
        $this->assertEmailTextBodyContains($email, "Bienvenue Test ! \nMerci d'avoir rejoint la quote machine. \nÀ bientôt.");
    }
}
