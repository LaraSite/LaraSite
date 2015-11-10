<?php

namespace Test\Unit\Http\Request;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Entities\Article;
use Mockery as m;

class ArticleRequestTest extends \TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    public function testValidationWithValidData()
    {
        $this->mock(Article::class);
        $this->mock->shouldReceive('create')->once()->andReturn(new Article());
        $input = $this->validData(['category_id' => 1]);

        $response = $this->call('POST', route('admin.articles.store'), $input);

        $this->assertRedirectedTo('/admin/articles');
    }

    public function testValidationWithoutTitle()
    {
        $this->callWithInvalidData(['title' => '']);
    }

    public function testValidationWithoutBody()
    {
        $this->callWithInvalidData(['body' => '']);
    }

    public function testValidationWithValidStatus()
    {
        $statuses = Article::$statuses;
        $this->mock(Article::class);
        $this->mock->shouldReceive('create')->times(count($statuses))->andReturn(new Article());
        foreach ($statuses as $status) {
            $input = $this->validData(['status' => $status]);

            $response = $this->call('POST', route('admin.articles.store'), $input);

            $this->assertRedirectedToRoute('admin.articles.index');
        }
    }

    public function testValidationWithInvalidStatus()
    {
        $this->callWithInvalidData(['status' => 'INVALID_STATUS']);
    }

    public function testValidationWithoutStatus()
    {
        $this->callWithInvalidData(['status' => '']);
    }

    public function testValidationWithoutPublishedAt()
    {
        $this->callWithInvalidData(['published_at' => '']);
    }

    public function testValidationWithInvalidPublishedAt()
    {
        $this->callWithInvalidData(['published_at' => 'INVALID_DATE']);
    }

    protected function validData(array $datas = [])
    {
        $default =  [
            'title' => 'foo',
            'body' => 'bar',
            'status' => 'Published',
            'published_at' => '2015-10-30 00:00',
        ];

        return array_merge($default, $datas);
    }

    protected function callWithInvalidData(array $inputs)
    {
        $response = $this->call('POST', route('admin.articles.store'), $this->validData($inputs));

        foreach ($inputs as $key => $value) {
            $this->assertSessionHasErrors($key);
        }
        $this->assertTrue($response->isRedirect());
//        $this->dumpErrorMessages();
    }
}
