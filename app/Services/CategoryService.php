<?php

namespace App\Services;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryService extends BaseService
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository)
    {}

    public function all()
    {
        return $this->categoryRepository->all();
    }

    public function create(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    public function update(array $data, string $id)
    {
        return $this->categoryRepository->update($data, $id);
    }

    public function delete(string $id)
    {
        return $this->categoryRepository->delete($id);
    }
    
}