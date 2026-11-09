<?php

namespace App\Http\Requests;

use App\Hari;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePelajaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'teacher' => $this->filled('teacher') ? $this->string('teacher')->toString() : null,
            'room' => $this->filled('room') ? $this->string('room')->toString() : null,
            'description' => $this->filled('description') ? $this->string('description')->toString() : null,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'day' => ['required', 'string', Rule::in(Hari::values())],
            'subject_name' => ['required', 'string', 'max:255'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'teacher' => ['nullable', 'string', 'max:255'],
            'room' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'subject_name.required' => 'Nama pelajaran wajib diisi.',
            'start_time.required' => 'Jam mulai wajib diisi.',
            'end_time.required' => 'Jam selesai wajib diisi.',
            'end_time.after' => 'Jam selesai harus lebih besar daripada jam mulai.',
            'day.in' => 'Hari tidak valid.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'day' => 'hari',
            'subject_name' => 'nama pelajaran',
            'start_time' => 'jam mulai',
            'end_time' => 'jam selesai',
            'teacher' => 'nama guru',
            'room' => 'ruangan',
            'description' => 'keterangan',
        ];
    }
}
