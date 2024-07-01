<?php

namespace App\Pipelines\Filter\Todo;

use Closure;

class CompletedFilter
{
    public function handle($content, Closure $next)
    {
        $search = request()->input('completed');
        if (isset($search)) {
            $query = $content->where('completed', (int) $search);
        } else {
            $query = $content;
        }
        return $next($query);
    }
}