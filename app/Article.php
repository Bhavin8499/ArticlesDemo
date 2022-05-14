<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'header_image',
    ];

    /**
     * The attributes that should be appended.
     *
     * @var array
     */
    protected $appends = ['header_image_url'];

    public function getHeaderImageUrlAttribute() {
        $path = "/articles/" . $this->header_image;
        return asset("storage" . $path);
    }

}
