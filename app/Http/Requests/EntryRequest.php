<?php
/** @noinspection PhpUnused */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class EntryRequest
 * @package App\Http\Requests
 */
class EntryRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required',
            'code' => 'required|unique:entries,code',
            'xml' => 'mimes:xml'
        ];
    }

    /**
     * @return array
     */
    public function messages() {
        return [
            'name.required' => 'Поле "Название" не может быть пустым!',
            'code.required' => 'Поле "Код" не может быть пустым!',
            'code.unique' => 'Элемент с таким кодом уже существует!',
            'xml.mimes' => 'Файлы должен быть в формате XML!'
        ];
    }
}
