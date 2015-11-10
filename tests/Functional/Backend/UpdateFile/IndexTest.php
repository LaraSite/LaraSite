<?php

namespace Test\Functional\Backend\UploadFile;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Entities\UploadFile;
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
        $files = factory(UploadFile::class, 2)->create();

        $this->visit('/admin/upload_files')
            ->seeInElement('h1', 'File')
            ->see($files[0]->name)
            ->see($files[1]->name)
            ->see('1 / 1');  // paginator
    }

    public function testTagFormat()
    {
        $file = factory(UploadFile::class)->create();

        $this->visit('/admin/upload_files')
            ->see($file->name)
            ->see(sprintf("%.2f KB", $file->size / 1000));
    }

    public function testPagination()
    {
        factory(UploadFile::class, 16)->create();

        $this->visit('/admin/upload_files')
            ->see('1 / 2');  // paginator
    }
}
