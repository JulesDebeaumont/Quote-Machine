<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\Factory\CategoryFactory;
use App\Factory\QuoteFactory;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Exception\InvalidOptionException;
use Symfony\Component\Console\Tester\CommandTester;
use Zenstruck\Foundry\Test\Factories;

class RandomQuoteCommandTest extends KernelTestCase
{
    use Factories;

    public function fillDB()
    {
        CategoryFactory::createOne([
            'name' => 'The Witcher',
        ]);
        QuoteFactory::createMany(5);
    }

    public function testExecuteWithExistingCategory()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);

        $this->fillDB();

        $command = $application->find('app:random-quote');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command' => $command->getName(),
            '--category' => 'The Witcher',
        ]);

        $output = $commandTester->getDisplay();

        $this->assertStringNotContainsString('Pas de résultat pour la catégorie The Witcher', $output);
    }

    public function testExecuteWithoutExistingCategory()
    {
        $this->fillDB();

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
        $this->fillDB();

        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:random-quote');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command' => $command->getName(),
        ]);

        $output = $commandTester->getDisplay();

        $this->assertStringNotContainsString('Pas de résultat dans la base de donnée ', $output);
    }

    public function testExecuteWithWrongOption()
    {
        $this->fillDB();

        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:random-quote');
        $commandTester = new CommandTester($command);

        $this->expectExceptionMessage('The "--category" option requires a value.');
        $this->expectException(InvalidOptionException::class);

        $commandTester->execute([
            'command' => $command->getName(),
            '--category' => null,
        ]);
    }

    public function testExecuteWithEmptyDatabase()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:random-quote');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command' => $command->getName(),
        ]);

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('Pas de résultat dans la base de donnée ', $output);
    }
}
