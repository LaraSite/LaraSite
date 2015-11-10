<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Article extends Model
{
    public static $statuses = ['Published', 'Draft', 'Pending', 'Trash'];

    protected $fillable = ['title', 'body', 'status', 'published_at', 'category_id'];
    protected $dates = ['published_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function getCategoryNameAttribute()
    {
        if ($this->category) {
            return $this->category->name;
        }
        return "";
    }

    public function getTagListAttribute()
    {
        return $this->tags->lists('id')->all();
    }

    public function getTagNamesAttribute()
    {
        return join(', ', $this->tags()->lists('name')->all());
    }

    public function getMetaInfoAttribute()
    {
        $meta = [];
        if ($this->category_name) {
            $meta[] = "Category: ".$this->category_name;
        }
        if ($this->tag_names) {
            $meta[] = "Tag: ".$this->tag_names;
        }
        return join(' | ', $meta);
    }

    public function getSummaryAttribute()
    {
        return explode('<!--more-->', $this->body)[0];
    }

    public function setCategoryIdAttribute($value)
    {
        $this->attributes['category_id'] = empty($value) ? null : $value;
    }

    public function setPublishedAtAttribute($value)
    {
        $this->attributes['published_at'] = Carbon::parse($value);
    }

    public function statuses()
    {
        return self::$statuses;
    }

    public function status_options()
    {
        $statuses = $this->statuses();
        return array_combine($statuses, $statuses);
    }
}
