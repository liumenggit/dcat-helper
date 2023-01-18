<?php

namespace Liumenggit\Helper\Http\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;
use Liumenggit\Helper\Models\Helper as Model;

class Helper extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
