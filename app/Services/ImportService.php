<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntryRequest;
use App\Http\Requests\PostCallerService;

class ImportService {

    static $completed = 0;
    static $error = 0;


    /**
     * @param array $arContent
     * @return array
     */
    public static function import(array $arContent): array {

        if (isset($arContent['@attributes'])) {
            self::importHelper($arContent);
        } else {
            foreach ($arContent as $v) {
                self::importHelper($v);
            }
        }

        return [
            'error' => self::$error,
            'completed' => self::$completed,
        ];


    }

    /**
     * @param $el
     */
    protected static function importHelper($el) {
        $pc = new PostCallerService(EntryController::class, 'add', EntryRequest::class, $el['@attributes']);

        $test = $pc->call();

        if (isset($el['element'])) {
            $el['element']['@attributes']['entry_id'] = $test->getData()->id;
            self::importHelper($el['element']);
        }

        $test ? self::$completed++ : self::$error++;
    }
}
