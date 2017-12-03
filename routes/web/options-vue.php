<?php

/**
 * Vue js Trial.
 */
/** Index Page */
Route::get('options-vue', function () {
    return view('options.index-vue');
});

Route::group(['prefix'=>'api/options'], function () {
    Route::match(['GET', 'POST'], '/', function () {
        if (Request::isMethod('GET')) {
            return App\Entities\Options\Option::all();
        } else {
            return App\Entities\Options\Option::create(Request::only('key', 'value'));
        }
    });

    Route::match(['GET', 'PATCH', 'DELETE'], '/{id}', function ($id) {
        if (Request::isMethod('GET')) {
            return App\Entities\Options\Option::findOrFail($id);
        } elseif (Request::isMethod('PATCH')) {
            App\Entities\Options\Option::findOrFail($id)->update(Request::only('key', 'value'));

            return Response::json(Request::all());
        } else {
            return App\Entities\Options\Option::destroy($id);
        }
    });
});

// /** Fetch all options (API) */
// Route::get('api/options', function() {
//     return App\Entities\Options\Option::all();
// });

// /** Create new options (API) */
// use App\Http\Requests\Options\CreateRequest;
// Route::post('api/options', function(CreateRequest $req) {
//     return App\Entities\Options\Option::create($req->only('key','value'));
// });

// /** get one option (API) */
// Route::get('api/options/{id}', function($id) {
//     return App\Entities\Options\Option::findOrFail($id);
// });

// /** update one option (API) */
// use Illuminate\Http\Request;
// Route::patch('api/options/{id}', function(Request $req, $id) {
//     return App\Entities\Options\Option::findOrFail($id)->update($req->only('key','value'));
// });

// /** delete one option (API) */
// Route::delete('api/options/{id}', function($id) {
//     App\Entities\Options\Option::destroy($id);
//     return 'ok';
// });

/* end of Vue js Trial */
