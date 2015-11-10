<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Laracasts\Flash\Flash;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Requests\ArticleRequest;
use App\Http\Controllers\Controller;
use App\Entities\Article;
use App\Entities\Category;
use App\Entities\Tag;

class ArticlesController extends Controller
{
    /** @var  Article */
    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $articles = $this->article
            ->with('category')
            ->orderBy('published_at', 'desc')
            ->latest()
            ->paginate();

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $article = $this->article->newInstance([
            'published_at' => Carbon::now()
        ]);

        return view('admin.articles.create', compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ArticleRequest  $request
     * @return Response
     */
    public function store(ArticleRequest $request)
    {
        $article = $this->article->create($request->all());
        $article->tags()->attach($request->input('tag_list'));

        Flash::success(trans('message.entity_saved', ['entity' => trans('models.article')]));

        return redirect()->route('admin.articles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Article  $article
     * @return Response
     */
    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ArticleRequest  $request
     * @param  Article  $article
     * @return Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $article->update($request->all());
        $article->tags()->sync($request->input('tag_list', []));

        Flash::success(trans('message.entity_updated', ['entity' => trans('models.article')]));

        return redirect()->route('admin.articles.edit', ['id' => $article->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        $delete_items = $request->input('delete_items', []);

        if (count($delete_items) > 0) {
            $query = $this->article->whereIn('id', $delete_items);
            $query->delete();
        }

        Flash::success(trans('message.entity_deleted', ['entity' => trans('models.article')]));

        return redirect()->route('admin.articles.index');
    }
}
