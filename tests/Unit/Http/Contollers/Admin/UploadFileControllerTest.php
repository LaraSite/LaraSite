<?php

namespace Test\Unit\Http\Controllers\Admin;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\UploadFile;
use Symfony\Component\HttpFoundation\File\UploadedFile as File;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery as m;

class UploadFileControllerTest extends \TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        $this->mock(UploadFile::class);
    }

    public function testIndex()
    {
        // stub for view
        $files = factory(UploadFile::class, 3)->make();
        $paginator = new LengthAwarePaginator($files, count($files), 15);

        $this->mock
            ->shouldReceive('orderBy')->once()
            ->with('created_at', 'desc')
            ->andReturn(m::self())
            ->shouldReceive('paginate')->once()
            ->andReturn($paginator);

        $this->get(route('admin.upload_files.index'));

        $this->assertResponseOk();
        $this->assertViewHas('files', $paginator);
    }

    public function testStore()
    {
        $file = new File(public_path('img/pdf.png'), 'pdf.png', 'image/png', 999, null, true);

        $this->mock->shouldReceive('create')->once()
            ->with(['extension' => $file->guessExtension(), 'size' => $file->getSize()])
            ->andReturn(m::self())
            ->shouldReceive('move')->once()
            ->with($file);

        $this->call('POST', route('admin.upload_files.store'), [], [], ['submitted_file' => $file]);

        $this->assertEquals(200, $this->response->status());
    }

    public function testStoreIfHasNotFile()
    {
        $this->call('POST', route('admin.upload_files.store'));

        $this->assertEquals(400, $this->response->status());
    }

    public function testStoreIfFileIsInvalid()
    {
        // test mode FALSE
        $file = new File(public_path('img/pdf.png'), 'pdf.png', 'image/png', 999, null, false);

        $this->call('POST', route('admin.upload_files.store'), [], [], ['submitted_file' => $file]);

        $this->assertEquals(400, $this->response->status());
    }

    public function testStoreIfValidationFails()
    {
        $file = new File(public_path('img/pdf.png'), 'pdf.png', 'image/png', 999, null, true);

        $messageBag = m::mock(['first' => 'foo_bar_baz']);

        \Validator::shouldReceive('make')
            ->andReturnUsing(function ($inputs, $rules) {
                $this->assertEquals(
                    'required|mimes:pdf,gif,jpeg,png|max:1024',
                    $rules['submitted_file']
                );

                return m::self();
            })
            ->shouldReceive('fails')->once()
            ->andReturn(true)
            ->shouldReceive('errors')->once()
            ->andReturn($messageBag);

        $this->call('POST', route('admin.upload_files.store'), [], [], ['submitted_file' => $file]);

        $this->assertEquals(400, $this->response->status());
    }

    public function testStoreCatchException()
    {
        $file = new File(public_path('img/pdf.png'), 'pdf.png', 'image/png', 999, null, true);

        $this->mock->shouldReceive('create')->once()
            ->with(['extension' => $file->guessExtension(), 'size' => $file->getSize()])
            ->andReturn(m::self())
            ->shouldReceive('move')->once()
            ->with($file)
            ->andThrow(new \Exception('file move error!!'));

        $this->call('POST', route('admin.upload_files.store'), [], [], ['submitted_file' => $file]);

        $this->assertEquals(500, $this->response->status());
    }

    public function testDestroy()
    {
        $datas = ['delete_items' => [1, 2]];

        $this->mock->shouldReceive('whereIn')->once()
            ->with('id', $datas['delete_items'])
            ->andReturn(m::self())
            ->shouldReceive('get')->once()
            ->andReturn([m::self(), m::self()])
            ->shouldReceive('unlink')->times(2)
            ->shouldReceive('delete')->times(2);

        $this->delete(route('admin.upload_files.destroy'), $datas);

        $this->assertRedirectedToRoute('admin.upload_files.index');
        $this->assertSessionHas('flash_notification.message');
        $this->assertSessionHas('flash_notification.level', 'success');
    }

    public function testDestroyCatchException()
    {
        $datas = ['delete_items' => [1, 2]];

        $this->mock->shouldReceive('whereIn')->once()
            ->with('id', $datas['delete_items'])
            ->andReturn(m::self())
            ->shouldReceive('get')->once()
            ->andReturn([m::self(), m::self()])
            ->shouldReceive('unlink')
            ->andThrow(new \Exception('file unlink error!!'));

        $this->delete(route('admin.upload_files.destroy'), $datas);

        $this->assertRedirectedToRoute('admin.upload_files.index');
        $this->assertSessionHas('flash_notification.message');
        $this->assertSessionHas('flash_notification.level', 'danger');
    }
}
