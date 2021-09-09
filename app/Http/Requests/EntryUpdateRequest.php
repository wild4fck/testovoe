<?php
/** @noinspection PhpUnused */

namespace App\Http\Requests;

/**
 * Class EntryRequest
 * @package App\Http\Requests
 */
class EntryUpdateRequest extends EntryRequest {
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
        $rules = parent::rules();
        unset($rules['code']);
        return $rules;
    }

    /**
     * @return array
     */
    public function messages() {
        return [
            'name.required' => 'Поле "Название" не может быть пустым!',
            'code.required' => 'Поле "Код" не может быть пустым!',
            'code.unique' => 'Элемнт с таким кодом уже существует!',
            'xml.mimes' => 'Файлы должен быть в формате XML!'
        ];
    }
}
