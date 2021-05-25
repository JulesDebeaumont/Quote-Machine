<?php

declare(strict_types=1);

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class RandomQuoteCommandTest extends KernelTestCase
{
    /*
    public function testExecuteWithExistingCategory()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:random-quote');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command' => $command->getName(),
            '--category' => 'The Witcher',
        ]);

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('Citation aléatoire !', $output);
        $this->assertStringNotContainsString('Pas de résultat pour la catégorie The Witcher', $output);
    }

    public function testExecuteWithoutExistingCategory()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:random-quote');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command' => $command->getName(),
            '--category' => 'Big Bang Theory',
        ]);

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('Citation aléatoire !', $output);
        $this->assertStringContainsString('Pas de résultat pour la catégorie Big Bang Theory', $output);
    }

    public function testExecuteWithoutCategory()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:random-quote');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command' => $command->getName(),
        ]);

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('Citation aléatoire !', $output);
        $this->assertStringNotContainsString('Pas de résultat dans la base de donnée ', $output);
    }
    */
}
