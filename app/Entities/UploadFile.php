<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile as File;

class UploadFile extends Model
{
    const UPLOAD_DIR = 'uploads';

    protected $fillable = ['extension', 'size'];

    public function getNameAttribute()
    {
        return "{$this->id}.{$this->extension}";
    }

    public function getAbsoluteDirAttribute()
    {
        return public_path().'/'.self::UPLOAD_DIR;
    }

    public function getAbsolutePathAttribute()
    {
        return $this->absoluteDir . '/' . $this->name;
    }

    public function getUrlAttribute()
    {
        return '/'.self::UPLOAD_DIR.'/'.$this->name;
    }

    /**
     * @codeCoverageIgnore
     * @param File $file
     */
    public function move(File $file)
    {
        $file->move($this->absoluteDir, $this->name);
    }

    /**
     * @codeCoverageIgnore
     */
    public function unlink()
    {
        unlink($this->absolutePath);
    }
}
