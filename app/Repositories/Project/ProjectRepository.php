<?php

namespace App\Repositories\Project;

use App\Models\Project;
use App\Repositories\BaseRepository;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{

    public function getModel(): string
    {
        return Project::class;
    }

    public function update(array $data, string $id)
    {
        return tap($this->model->find($id))->update($data);
    }

    public function all()
    {
        return $this->model->whereHas('users', function ($query) {
            $query->where('user_id', auth()->id());
        })->paginate(5);
    }
}