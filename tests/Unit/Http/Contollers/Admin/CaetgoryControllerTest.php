<?php

namespace Test\Unit\Http\Controllers\Admin;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery as m;

class CategoryControllerTest extends \TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->mock(Category::class);
    }

    public function testIndex()
    {
        // stub for view
        $caegories = factory(Category::class, 3)->make();
        $paginator = new LengthAwarePaginator($caegories, count($caegories), 15);

        $this->mock
            ->shouldReceive('orderBy')->once()
            ->with('name', 'asc')
            ->andReturn(m::self())
            ->shouldReceive('paginate')->once()
            ->andReturn($paginator);

        $this->get(route('admin.categories.index'));

        $this->assertResponseOk();
        $this->assertViewHas('categories', $paginator);
    }

    public function testStore()
    {
        $datas = ['name' => 'foo'];

        $this->mock->shouldReceive('create')->once()
            ->with($datas);

        $this->post(route('admin.categories.store'), $datas);
//        $this->dumpErrorMessages();

        $this->assertRedirectedToRoute('admin.categories.index');
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

        $this->delete(route('admin.categories.destroy'), $datas);

        $this->assertRedirectedToRoute('admin.categories.index');
        $this->assertSessionHas('flash_notification.message');
        $this->assertSessionHas('flash_notification.level', 'success');
    }
}
