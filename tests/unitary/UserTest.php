<?php

declare(strict_types=1);

namespace App\Tests\unitary;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @dataProvider experienceAndLvlProvider
     */
    public function testGetUserLevel(int $experience, int $expected): void
    {
        $user = new User();
        $user->setExperience($experience);
        $this->assertSame($user->getUserLevel(), $expected);
    }

    public function experienceAndLvlProvider(): array
    {
        return
            [
                [0, 1],
                [1, 1],
                [101, 2],
                [100, 2],
                [10, 1],
                [-50, 1],
                [600, 4],
                [1000, 5],
                [999, 4],
            ];
    }

    /**
     * @dataProvider experiencePerLevelProvider
     */
    public function testGetXpLevel(int $level, int $expected): void
    {
        $user = new User();
        $this->assertSame($user->getExpLvl($level), $expected);
    }

    public function experiencePerLevelProvider(): array
    {
        return
        [
            [1, 0],
            [2, 100],
            [3, 300],
            [4, 600],
            [5, 1000],
            [6, 1500],
            [7, 2100],
            [8, 2800],
        ];
    }

    /**
     * @dataProvider experienceAndProgressProvider
     */
    public function testProgressLevel(int $experience, int $expected): void
    {
        $user = new User();
        $user->setExperience($experience);
        $this->assertSame($user->getProgressLevel(), $expected);
    }

    public function experienceAndProgressProvider(): array
    {
        return
        [
            [420, 40],
            [60, 60],
            [-50, 0],
            [100, 0],
        ];
    }
}
