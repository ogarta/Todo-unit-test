<?php

namespace App\Pipelines\Filter\Todo;

use Closure;

class CategoryFilter
{
    public function handle($content, Closure $next)
    {
        $search = request()->input('category_id');
        if (isset($search)) {
            $query = $content->where('category_id', (int) $search);
        } else {
            $query = $content;
        }
        return $next($query);
    }
}