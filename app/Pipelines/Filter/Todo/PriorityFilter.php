<?php

namespace App\Pipelines\Filter\Todo;

use Closure;

class PriorityFilter
{
    public function handle($content, Closure $next)
    {
        $search = request()->input('priority');
        if (isset($search)) {
            $query = $content->where('priority', (int) $search);
        } else {
            $query = $content;
        }
        return $next($query);
    }
}