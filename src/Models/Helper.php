<?php

namespace Liumenggit\Helper\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Helper extends Model
{
    use HasDateTimeFormatter;
    use SoftDeletes;

    protected $casts = [
        'args' => 'array',
    ];

    protected $table = 'dcat_helper';

}
