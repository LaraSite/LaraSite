<?php

namespace Test\Unit\Http\Controllers\Admin;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Entities\Article;
use Mockery as m;

class ArticleControllerTest extends \TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->mock(Article::class);
    }

    public function testIndex()
    {
        // stub for view
        $articles = factory(Article::class, 3)->make();
        $paginator = new LengthAwarePaginator($articles, count($articles), 15);

        $this->mock
            ->shouldReceive('with')->once()
            ->with('category')->andReturn(m::self())
            ->shouldReceive('orderBy')->once()
            ->with('published_at', 'desc')
            ->andReturn(m::self())
            ->shouldReceive('latest')->once()
            ->andReturn(m::self())
            ->shouldReceive('paginate')->once()
            ->andReturn($paginator);

        $this->get(route('admin.articles.index'));

        $this->assertResponseOk();
        $this->assertViewHas('articles', $paginator);
    }

    public function testCreate()
    {
        $article = factory(Article::class)->make(); // stub for view

        $this->mock->shouldReceive('newInstance')->once()
            ->andReturnUsing(function (array $attributes) use ($article) {
                $this->assertEquals(1, count($attributes));
                $this->assertInstanceOf(\Carbon\Carbon::class, $attributes['published_at']);

                return $article;
            });

        $this->get(route('admin.articles.create'));

        $this->assertResponseOk();
        $this->assertViewHas('article', $article);
    }

    public function testStore()
    {
        $datas = $this->validData();

        $this->mock->shouldReceive('create')->once()
            ->with($datas)
            ->andReturn(m::self())
            ->shouldReceive('tags')->once()
            ->andReturn(m::self())
            ->shouldReceive('attach')->once()
            ->with($datas['tag_list']);

        $this->post(route('admin.articles.store'), $datas);
//        $this->dumpErrorMessages();

        $this->assertRedirectedToRoute('admin.articles.index');
        $this->assertSessionHas('flash_notification.message');
        $this->assertSessionHas('flash_notification.level', 'success');
    }

    public function testEdit()
    {
        $article = factory(Article::class)->make(); // stub for view
        $this->mockRouteModelBinding($this->mock, $article);

        $this->get(route('admin.articles.edit', ['id' => 1]));

        $this->assertResponseOk();
        $this->assertViewHas('article', $article);
    }

    public function testUpdate()
    {
        $datas = $this->validData(['id' => 1]);

        $this->mock->shouldReceive('update')->once()->with($datas);
        $this->mock->shouldReceive('tags')->once()
            ->andReturn(m::self())
            ->shouldReceive('sync')->once()
            ->with($datas['tag_list']);
        $this->mock->shouldReceive('getAttribute')->once()
            ->with('id')
            ->andReturn($datas['id']);

        $this->mockRouteModelBinding($this->mock, $this->mock);

        $this->put(route('admin.articles.update', ['id' => $datas['id']]), $datas);
//        $this->dumpErrorMessages();
//        $this->dump();

        $this->assertRedirectedToRoute('admin.articles.edit', ['id' => 1]);
        $this->assertSessionHas('flash_notification.message');
        $this->assertSessionHas('flash_notification.level', 'success');
    }

    public function testDestroy()
    {
        $datas = ['delete_items' => [1, 2, 3]];

        $this->mock->shouldReceive('whereIn')->once()
            ->with('id', $datas['delete_items'])
            ->andReturn(m::self())
            ->shouldReceive('delete')->once();

        $this->delete(route('admin.articles.destroy'), $datas);

        $this->assertRedirectedToRoute('admin.articles.index');
        $this->assertSessionHas('flash_notification.message');
        $this->assertSessionHas('flash_notification.level', 'success');
    }

    protected function validData(array $datas = [])
    {
        $default = [
            'title' => 'TITLE',
            'body' => 'BODY',
            'category_id' => '1',
            'tag_list' => [
                0 => 1
            ],
            'status' => 'Published',
            'published_at' => '2015-11-02 00:00:00',
        ];

        return array_merge($default, $datas);
    }
}
