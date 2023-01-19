<?php

namespace Liumenggit\Helper\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

class AdminSettings extends Model
{
    use HasDateTimeFormatter;

    protected $casts = [
        'value' => 'array',
    ];

    protected $guarded = [];
    protected $table = 'admin_settings';

}
