<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    /**Start Relations */
    /**End Relations */

    /**Start Scopes*/
    public function scopeFilter($query, array $filter = [])
    {
        if ($title = Arr::get($filter, 'title')) {
            $query->where('posts.title', 'like', '%'.$title.'%');
        }
    }
    /**End Scopes */

    /**Start Mutators*/
    /**End Mutators */

    /**Start Helper*/
    /**End Helper*/
}
