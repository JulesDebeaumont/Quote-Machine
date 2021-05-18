<?php

declare(strict_types=1);

namespace App\Tests\unitary;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @dataProvider experienceProvider
     */
    public function testLevelCalculation(int $experience, int $expected): void
    {
        //$mockUser = $this->createPartialMock(User::class, ['getUserLevel']);
        //$mockUser->method('getUserLevel')->willReturn($experience);
        //$this->assertSame($mockUser->getUserLevel(), $expected);
    }

    public function experienceProvider(): array
    {
        return
            [
                [0, 1],
                [101, 2],
                [100, 2],
                [-50, 1],
            ];
    }

    public function testProgress(): void
    {
    }
}
