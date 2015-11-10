<?php

namespace Test\Unit\Entities;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Article;
use App\Entities\Category;
use App\Entities\Tag;

class ArticleTest extends \TestCase
{
    use DatabaseTransactions;

    public function testGetCategoryName()
    {
        /** @var Article $article */
        $article = factory(Article::class)->make();
        $category = factory(Article::class)->make([
            'name' => 'category-A'
        ]);
        $article->category()->associate($category);

        $this->assertEquals('category-A', $article->categoryName);
    }

    public function testGetTagList()
    {
        /** @var Article $article */
        $article = factory(Article::class)->create();
        $tags = factory(Tag::class, 3)->create();

        $ids = [];
        foreach ($tags as $tag) {
            $ids[] = $tag->id;
        }
        $article->tags()->attach($ids);

        $this->assertEquals($ids, $article->tag_list);
    }

    public function testGetTagName()
    {
        $article = factory(Article::class)->create();
        $tags = factory(Tag::class, 3)->create();

        $names = [];
        foreach ($tags as $tag) {
            $article->tags()->attach($tag->id);
            $names[] = $tag->name;
        }

        $this->assertEquals(join(', ', $names), $article->tag_names);
    }

    public function testGetMetaInfoWithCategory()
    {
        $article = factory(Article::class)->create();
        $category = factory(Category::class)->create([
            'name' => 'category-A'
        ]);

        $article->category()->associate($category);

        $this->assertEquals('Category: category-A', $article->meta_info);
    }

    public function testGetMetaInfoWithTag()
    {
        $article = factory(Article::class)->create();
        $tag = factory(Tag::class)->create([
            'name' => 'tag-A'
        ]);

        $article->tags()->attach($tag->id);

        $this->assertEquals('Tag: tag-A', $article->meta_info);
    }

    public function testGetMetaInfoWithCategoryAndTag()
    {
        $article = factory(Article::class)->create();
        $category = factory(Category::class)->create([
            'name' => 'category-A'
        ]);
        $tag = factory(Tag::class)->create([
            'name' => 'tag-A'
        ]);

        $article->category()->associate($category);
        $article->tags()->attach($tag->id);

        $this->assertEquals('Category: category-A | Tag: tag-A', $article->meta_info);
    }

    public function testGetSummary()
    {
        $article = factory(Article::class)->make([
            'body' => 'summary<!--more-->detail',
        ]);

        $this->assertEquals('summary', $article->summary);
    }

    public function testSetCategoryId()
    {
        $article = factory(Article::class)->make();
        $article->category_id = 1;
        $this->assertEquals(1, $article->category_id);

        $article->category_id = '';
        $this->assertEquals(null, $article->category_id);
    }

    public function testSetPublishedAt()
    {
        $article = factory(Article::class)->make();
        $article->published_at = '1968/12/09 00:00';

        $this->assertEquals(\Carbon\Carbon::create(1968, 12, 9, 00, 00), $article->published_at);
    }

    public function testStatusOptions()
    {
        $article = factory(Article::class)->make();
        $options = ['Published' => 'Published', 'Draft' => 'Draft', 'Pending' => 'Pending', 'Trash' =>'Trash'];

        $this->assertEquals($options, $article->status_options());
    }
}
