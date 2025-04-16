<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string|null $sort
 * @property string|null $direction
 * @property string|null $start_date
 * @property string|null $end_date
 */
class FilterSortRequest extends FormRequest
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
        return [
            'sort' => 'sometimes|in:title,starts_at,ends_at,location,price,capacity',
            'direction' => 'sometimes|in:asc,desc',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ];
    }
}
