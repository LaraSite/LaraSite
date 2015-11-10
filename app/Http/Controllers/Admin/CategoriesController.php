<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Entities\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    /** @var  Category */
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $categories = $this->category->orderBy('name', 'asc')->paginate();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        $this->category->create($request->all());

        \Flash::success(trans('message.entity_saved', ['entity' => trans('models.category')]));

        return redirect()->route('admin.categories.index');
    }

    public function destroy(Request $request)
    {
        $delete_items = $request->input('delete_items');

        if (count($delete_items) > 0) {
            $query = $this->category->whereIn('id', $delete_items);
            $query->delete();
        }

        \Flash::success(trans('message.entity_deleted', ['entity' => trans('models.category')]));

        return redirect()->route('admin.categories.index');
    }
}
