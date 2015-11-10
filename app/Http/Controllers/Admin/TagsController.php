<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entities\Tag;
use App\Http\Requests\TagRequest;

class TagsController extends Controller
{
    /** @var  Tag */
    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function index()
    {
        $tags = $this->tag->orderBy('name', 'asc')->paginate();

        return view('admin.tags.index', compact('tags'));
    }

    public function store(TagRequest $request)
    {
        $this->tag->create($request->all());

        \Flash::success(trans('message.entity_saved', ['entity' => trans('models.tag')]));

        return redirect()->route('admin.tags.index');
    }

    public function destroy(Request $request)
    {
        $delete_items = $request->input('delete_items');

        if (count($delete_items) > 0) {
            $query = $this->tag->whereIn('id', $delete_items);
            $query->delete();
        }

        \Flash::success(trans('message.entity_deleted', ['entity' => trans('models.tag')]));

        return redirect()->route('admin.tags.index');
    }
}
