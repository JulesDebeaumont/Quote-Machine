<?php

namespace App\DataFixtures;

use App\Factory\QuoteFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;



class QuoteFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        QuoteFactory::createMany(5);

        /*
        $quote1 = new Quote();
        $quote1->setContent('Content 1 quote blablabla');
        $quote1->setMeta('Meta 1 blablabla');

        $quote2 = new Quote();
        $quote2->setContent('Content 2 quote blablabla');
        $quote2->setMeta('Meta 2 blablabla');
        */


    }
}
