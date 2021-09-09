<?php
/** @noinspection PhpUndefinedMethodInspection */
/** @noinspection PhpUndefinedMethodInspection */
/** @noinspection PhpUnused */

namespace App\Http\Controllers;

use App\Http\Requests\EntryRequest;
use App\Http\Requests\EntryUpdateRequest;
use App\Models\Entry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class EntryController
 * @package App\Http\Controllers
 */
class EntryController extends Controller {
    private $entry;

    public function __construct() {
        $this->entry = new Entry;
    }

    /**
     * @param EntryRequest $request
     * @return JsonResponse
     */
    public function add(EntryRequest $request) {
        $entry = new Entry;
        $entry->code = $request->input('code');
        $this->exec($request, $entry);

        return NotifyService::notify(
            'Добвление записи',
            'Запись - "' . $request->input('name') . '" была добвлена!',
            ['id' => $entry->id]
        );

    }

    /**
     * @param $request
     * @param $entry
     */
    private function exec($request, Entry $entry) {
        $entry->name = $request->input('name');
        $entry->entry_id = $request->input('entry_id');
        $entry->description = $request->input('description');
        $entry->save();
    }

    /**
     * @param EntryUpdateRequest $request
     * @return JsonResponse
     */
    public function edit(EntryUpdateRequest $request) {
        $entry = Entry::find($request->input('id'));

        $this->exec($request, $entry);

        return NotifyService::notify(
            'Изменение записи',
            'Запись - "' . $request->input('name') . '" была изменена!'
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function delete(Request $request) {
        Entry::destroy($request->input('id'));

        return NotifyService::notify(
            'Удаление завершено!',
            'Запись c ID - ' . $request->input('id') . ' была удалена!'
        );

    }

    public function getAll() {
        return $this->entry->all();
    }

    public function getTree() {
        return response()->json($this->entry->whereNull('entry_id')->with('children')->orderBy('name', 'asc')->get());
    }

    public function search(Request $request) {
        $string = $request->input('searchString');
        $entries = $this->entry
            ->where('name', 'like', "%{$string}%")
            ->orWhere('code', 'like', "%{$string}%")
            ->with('children')->orderBy('name', 'asc')
            ->get();
        return response()->json($entries);
    }
}
