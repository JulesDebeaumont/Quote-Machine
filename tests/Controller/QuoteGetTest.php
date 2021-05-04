<?php

namespace App\Tests\Controller;

use App\Factory\CategoryFactory;
use App\Factory\QuoteFactory;
use App\Tests\TestCases\ApiPlatformTestCase;

class QuoteGetTest extends ApiPlatformTestCase
{
    protected static function getPropertiesQuote(): array
    {
        return [
            'content',
            'meta',
            'category',
        ];
    }

    protected static function getPropertiesCategory(): array
    {
        return [
            'name',
        ];
    }

    public function testGetQuote()
    {
        // 1. 'Arrange'

        $data = [
            'content' => 'testContent',
            'meta' => 'testMeta',
        ];

        QuoteFactory::new()->create($data);

        // 2. 'Act'
        //static ::ensureKernelShutdown();
        self::jsonld_request('GET', '/api/quotes/1');

        // 3. 'Assert'
        $json = self::lastJsonResponseWithAsserts(ApiPlatformTestCase::ENTITY, 'Quote');
        self::assertJsonIsAnItem($json, self::getPropertiesQuote(), $data);
    }

    public function testGetCategory()
    {
        // 1. 'Arrange'
        $data = ['name' => 'categoryTest'];
        CategoryFactory::new()->create($data);

        // 2. 'Act'
        //static ::ensureKernelShutdown();
        self::jsonld_request('GET', '/api/categories/1');

        // 3. 'Assert'
        $json = self::lastJsonResponseWithAsserts(ApiPlatformTestCase::ENTITY, 'Category');
        self::assertJsonIsAnItem($json, self::getPropertiesCategory(), $data);
    }
}
