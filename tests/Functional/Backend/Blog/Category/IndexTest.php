<?php

namespace Test\Functional\Backend\Blog\Category;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Entities\Article;
use App\Entities\Category;
use Illuminate\Auth\GenericUser;

class IndexTest extends \TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $user = factory(GenericUser::class)->make();

        $this->actingAs($user);
    }

    public function testShowList()
    {
        $categories = factory(Category::class, 2)->create();

        $this->visit('/admin/categories')
            ->seeInElement('h1', 'Category')
            ->see($categories[0]->name)
            ->see($categories[1]->name)
            ->see('1 / 1');     // paginator
    }

    public function testCategoryFormat()
    {
        $category = factory(Category::class)->create();
        $articles = factory(Article::class, 2)->create([
            'category_id' => $category->id
        ]);

        $this->visit('/admin/categories')
            ->see($category->name)
            ->seeInElement('td > span.badge', '2');
    }

    public function testPagination()
    {
        factory(Category::class, 16)->create();

        $this->visit('/admin/categories')
            ->see('1 / 2');     // paginator
    }

    public function testDoesNotExist()
    {
        $this->visit('/admin/categories')
            ->see('Category does not exist.');
    }
}
