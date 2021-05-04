<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories = json_decode(file_get_contents(
            __DIR__.
            DIRECTORY_SEPARATOR.
            'data'.
            DIRECTORY_SEPARATOR.
            'category.json'
        ), true);

        foreach ($categories as $category) {
            $categoryEntity = CategoryFactory::new()->create($category);
            if (isset($category['imageName'])) {
                $this->setImage(
                    $categoryEntity->object(),
                    (
                        __DIR__.
                        DIRECTORY_SEPARATOR.
                        'data'.
                        DIRECTORY_SEPARATOR.
                        'img'.
                        DIRECTORY_SEPARATOR.
                        $category['imageName']
                    ),
                    $category['imageName']);
            }
        }
        $manager->flush();
    }

    public function setImage(Category $category, string $path, string $filename)
    {
        $tmpPath = tempnam(sys_get_temp_dir(), 'categories_images');
        copy($path, $tmpPath);

        $category->setImageFile(new UploadedFile(
            $tmpPath,
            $filename,
            'image/jpeg',
            null,
            true
        ));
    }
}
