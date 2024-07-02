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
        $project = $this->projectRepository->update($data, $id);

        $project->users()->detach();
        $project->users()->attach($data['users']);

        return $project;
    }

    public function find(string $id)
    {
        return $this->projectRepository->find($id);
    }

    public function delete(string $id)
    {
        return $this->projectRepository->delete($id);
    }
}