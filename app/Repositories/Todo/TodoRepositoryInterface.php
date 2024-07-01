<?php

namespace App\Repositories\Todo;

use App\Repositories\BaseRepository;

interface TodoRepositoryInterface
{
    public function getListByFilter(array $data);
}