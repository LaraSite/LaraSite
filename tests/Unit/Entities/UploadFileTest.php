<?php

namespace Test\Unit\Entities;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\UploadFile;

class UploadFileTest extends \TestCase
{
    use DatabaseTransactions;

    public function testGetName()
    {
        /** @var UploadFile $article */
        $file = factory(UploadFile::class)->create();

        $this->assertEquals('1.jpeg', $file->name);
    }

    public function testGetAbsoluteDir()
    {
        /** @var UploadFile $article */
        $file = factory(UploadFile::class)->create();

        $this->assertEquals(public_path().'/uploads', $file->absolute_dir);
    }

    public function testGetAbsolutePath()
    {
        /** @var UploadFile $article */
        $file = factory(UploadFile::class)->create();

        $this->assertEquals(public_path().'/uploads/1.jpeg', $file->absolute_path);
    }

    public function testGetUrl()
    {
        /** @var UploadFile $article */
        $file = factory(UploadFile::class)->create();

        $this->assertEquals('/uploads/1.jpeg', $file->url);
    }
}
