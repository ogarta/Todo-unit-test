<?php

namespace Tests\Unit;

use App\Repositories\Todo\TodoRepository;
use App\Services\TodoService;
use PHPUnit\Framework\TestCase;

class TodoTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_standard_data() {
        $data = [
            'title' => 'Test Todo',
            'category_id' => "1",
            'completed' => '',
        ];

        $standardData = (new TodoService(new TodoRepository()))->standardizeData($data);

        $this->assertEquals($standardData, [
            'category_id' => 1,
            'title' => 'Test Todo',
            'completed' => null,
        ]);

    }
}
