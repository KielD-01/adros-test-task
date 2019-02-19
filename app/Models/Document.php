<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Document
 * @package App\Models
 * @property integer id
 * @property string path
 * @property string thumbnail
 */
class Document extends Model
{
    protected $fillable = [
        'path',
        'thumbnail'
    ];
}
