<?php

namespace App\Services;

use App\Repositories\Project\ProjectRepositoryInterface;

class ProjectService extends BaseService
{
    public function __construct(private ProjectRepositoryInterface $projectRepository)
    {}

    public function getAll()
    {
        return $this->projectRepository->all();
    }
    
    public function create(array $data)
    {
        $project = $this->projectRepository->create($data);
        $project->users()->attach(auth()->id(), ['user_id' => auth()->id()]);
        return $project;
    }

    public function update(array $data, string $id)
    {
        return $this->projectRepository->update($data, $id);
    }

    public function find(string $id)
    {
        return $this->projectRepository->find($id)->load('users');
    }
}