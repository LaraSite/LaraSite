<?php

namespace Test\Unit\Entities;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Article;
use App\Entities\Category;

class CategoryTest extends \TestCase
{
    use DatabaseTransactions;

    public function testArticles()
    {
        /** @var Category $category */
        $category = factory(Category::class)->create();
        $articles = factory(Article::class, 3)->create([
            'category_id' => $category->id
        ]);

        $this->assertEquals(3, $category->articles()->count());
    }
}
