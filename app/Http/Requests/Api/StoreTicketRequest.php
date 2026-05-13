<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^\+[1-9]\d{7,14}$/'],
            'email' => ['nullable', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:5000'],
            'files' => ['nullable', 'array', 'max:5'],
            'files.*' => ['file', 'max:10240', 'mimes:jpg,jpeg,png,gif,pdf,doc,docx,zip'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Поле "Имя" обязательно для заполнения.',
            'phone.required' => 'Поле "Телефон" обязательно для заполнения.',
            'phone.regex' => 'Введите телефон в формате E.164, например +380991234567.',
            'subject.required' => 'Поле "Тема" обязательно для заполнения.',
            'body.required' => 'Поле "Сообщение" обязательно для заполнения.',
            'files.max' => 'Можно прикрепить не более 5 файлов.',
            'files.*.max' => 'Размер каждого файла не должен превышать 10 МБ.',
            'files.*.mimes' => 'Разрешённые форматы: jpg, jpeg, png, gif, pdf, doc, docx, zip.',
        ];
    }
}
