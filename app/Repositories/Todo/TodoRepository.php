<?php

namespace App\Repositories\Todo;

use App\Models\Todo;
use App\Pipelines\Filter\Todo\CategoryFilter;
use App\Pipelines\Filter\Todo\CompletedFilter;
use App\Pipelines\Filter\Todo\DueDateFilter;
use App\Pipelines\Filter\Todo\PriorityFilter;
use App\Repositories\BaseRepository;

class TodoRepository extends BaseRepository implements TodoRepositoryInterface
{

    public function getModel(): string
    {
        return Todo::class;
    }

    public function getListByFilter(array $data)
    {
        // $query = $this->model
        //     ->when(isset($data['category_id']), function ($query) use ($data) {
        //         return $query->where('category_id', (int)  $data['category_id']);
        //     })
        //     ->when(isset($data['completed']), function ($query) use ($data) {
        //         return $query->where('completed', (int) $data['completed']);
        //     })
        //     ->when(isset($data['priority']), function ($query) use ($data) {
        //         return $query->where('priority', (int) $data['priority']);
        //     })
        //     ->when(isset($data['due_date']), function ($query) use ($data) {
        //         return $query->where('due_date', $data['due_date']);
        //     });

        $query = $this->model->query()
            ->filter([
                CategoryFilter::class,
                DueDateFilter::class,
                CompletedFilter::class,
                PriorityFilter::class
            ]);

        return $query
            ->where('user_id', auth()->id())
            ->whereNull('parent_id')
            ->with('category')
            ->orderBy('created_at', 'desc')->orderBy('priority', 'asc')->get();
    }

    public function find(string $id)
    {
        return $this->model->with(['category', 'subtasks'])->findOrfail($id);
    }
}