<?php
/** @noinspection PhpUnused */

namespace App\Http\Controllers;

use App\Http\Requests\ImportRequest;
use Exception;

/**
 * Class ImportController
 * @package App\Http\Controllers
 */
class ImportController extends Controller {

    /**
     * @param ImportRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function import(ImportRequest $request) {
        $sxObj = simplexml_load_file($request->file('xml'));
        $arFromXml = json_decode(json_encode($sxObj), true);
        $arContent = $arFromXml[array_key_first($arFromXml)];


        if (is_array($arContent) && !empty($arContent)) {
            $importRes = ImportService::import($arContent);
        } else {
            throw new Exception('Ошибка!');
        }

        return NotifyService::notify('Импорт завершен!', "Добавлено: {$importRes['completed']} <br> Ошибок: {$importRes['error']}");
    }
}
