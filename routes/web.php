<?PHP

use Illuminate\Support\Facades\Auth;
use illuminate\support\facades\route;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
|
| HERE IS WHERE YOU CAN REGISTER WEB ROUTES FOR YOUR APPLICATION. THESE
| ROUTES ARE LOADED BY THE ROUTESERVICEPROVIDER WITHIN A GROUP WHICH
| CONTAINS THE "WEB" MIDDLEWARE GROUP. NOW CREATE SOMETHING GREAT!
|
*/

route::get('/', function () {
    return view('home');
});

Route::post('/add-entry', 'EntryController@add');
Route::post('/edit-entry', 'EntryController@edit');
Route::post('/import', 'ImportController@import');
Route::post('/search', 'EntryController@search');
Route::post('/delete', 'EntryController@delete');

Route::get('/get-all-entries', 'EntryController@getAll');
Route::get('/get-all-entries-tree', 'EntryController@getTree');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
