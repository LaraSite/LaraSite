<?php

use App\Entities\Tag;
use App\Entities\Category;

function category_list()
{
    $categories = Category::orderBy('name', 'asc')->lists('name', 'id')->toArray();
    $categories = ['' => 'None'] + $categories;

    return $categories;
}

function tag_list()
{
    $tags = Tag::orderBy('name', 'asc')->lists('name', 'id')->toArray();

    return $tags;
}
