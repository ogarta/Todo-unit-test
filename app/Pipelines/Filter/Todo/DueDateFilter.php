<?php

namespace App\Pipelines\Filter\Todo;

use Closure;

class DueDateFilter
{
    public function handle($content, Closure $next)
    {
        $search = request()->input('due_date');
        if (isset($search)) {
            $query = $content->where('due_date', $search);
        } else {
            $query = $content;
        }
        return $next($query);
    }
}