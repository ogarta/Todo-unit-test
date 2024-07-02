<?php

namespace App\Services;
use App\Models\Todo;
use App\Repositories\Todo\TodoRepositoryInterface;

class TodoService extends BaseService
{
    public function __construct(private TodoRepositoryInterface $todoRepository)
    {}

    public function getAll(array $data)
    {
        $listTodo =  $this->todoRepository->getListByFilter($data);

        $grouped = $listTodo->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        });

        return $grouped;
    }

    public function find(string $id)
    {
        return $this->todoRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->todoRepository->create($this->standardizeData($data));
    }

    public function update(array $data, string $id)
    {
        return $this->todoRepository->update($this->standardizeData($data), $id);
    }

    public function delete(string $id)
    {
        return $this->todoRepository->delete($id);
    }

    public function createSubtask(array $data, Todo $todo)
    {
        return $todo->subtasks()->create($this->standardizeData($data));
    }

    public function getFilter(array $data)
    {
        return [
            'category_id' => $data['category_id'] ?? null,
            'completed' => $data['completed'] ?? null,
            'priority' => $data['priority'] ?? null,
            'due_date' => $data['due_date'] ?? null
        ];
    }

    public function standardizeData(array $data)
    {
        $keys = ['category_id', 'priority', 'completed'];
        foreach ($data as $key => $value) {
            if (in_array($key, $keys)) {
                $data[$key] = $value ? (int) $value : null;
            }
        }
        return $data;
    }
}