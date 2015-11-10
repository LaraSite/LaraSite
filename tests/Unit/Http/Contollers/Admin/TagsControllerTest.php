<?php

namespace Test\Unit\Http\Controllers\Admin;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Tag;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery as m;

class TagsControllerTest extends \TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->mock(Tag::class);
    }

    public function testIndex()
    {
        // stub for view
        $tags = factory(Tag::class, 3)->make();
        $paginator = new LengthAwarePaginator($tags, count($tags), 15);

        $this->mock
            ->shouldReceive('orderBy')->once()
            ->with('name', 'asc')
            ->andReturn(m::self())
            ->shouldReceive('paginate')->once()
            ->andReturn($paginator);

        $this->get(route('admin.tags.index'));

        $this->assertResponseOk();
        $this->assertViewHas('tags', $paginator);
    }

    public function testStore()
    {
        $datas = ['name' => 'foo'];

        $this->mock->shouldReceive('create')->once()
            ->with($datas);

        $this->post(route('admin.tags.store'), $datas);
//        $this->dumpErrorMessages();

        $this->assertRedirectedToRoute('admin.tags.index');
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

        $this->delete(route('admin.tags.destroy'), $datas);

        $this->assertRedirectedToRoute('admin.tags.index');
        $this->assertSessionHas('flash_notification.message');
        $this->assertSessionHas('flash_notification.level', 'success');
    }
}
