<?php

namespace App\Http\Requests\Todo;

use App\Enums\CommonConst;
use App\Enums\PriorityEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if (isset($this->completed)) {
            return [
                'completed' => 'required|in:' . CommonConst::COMPLETED . ',' . CommonConst::INCOMPLETE,
            ];
        }
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'due_date' => 'nullable|date',
            'priority' => ['required',Rule::enum(PriorityEnum::class)],
            'completed' => 'nullable|in:' . implode(',', [CommonConst::COMPLETED, CommonConst::INCOMPLETE]),
            'project_id' => 'required|exists:projects,id',
        ];
    }
}
