<?php

namespace App\Factory;

use App\Entity\Quote;
use App\Repository\QuoteRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @method static Quote|Proxy createOne(array $attributes = [])
 * @method static Quote[]|Proxy[] createMany(int $number, $attributes = [])
 * @method static Quote|Proxy find($criteria)
 * @method static Quote|Proxy findOrCreate(array $attributes)
 * @method static Quote|Proxy first(string $sortedField = 'id')
 * @method static Quote|Proxy last(string $sortedField = 'id')
 * @method static Quote|Proxy random(array $attributes = [])
 * @method static Quote|Proxy randomOrCreate(array $attributes = [])
 * @method static Quote[]|Proxy[] all()
 * @method static Quote[]|Proxy[] findBy(array $attributes)
 * @method static Quote[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Quote[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static QuoteRepository|RepositoryProxy repository()
 * @method Quote|Proxy create($attributes = [])
 */
final class QuoteFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();


    }

    protected function getDefaults(): array
    {
        return
            [
                'content' => self::faker()->text(100),
                'meta' => self::faker()->name(),
                'category' => CategoryFactory::random(),
            ];
    }

    protected function initialize(): self
    {
        // see https://github.com/zenstruck/foundry#initialization
        return $this
            // ->afterInstantiate(function(Quote $quote) {})
        ;
    }

    protected static function getClass(): string
    {
        return Quote::class;
    }
}
