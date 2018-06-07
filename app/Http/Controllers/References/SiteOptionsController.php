<?php

namespace App\Http\Controllers\References;

use Illuminate\Http\Request;
use App\Entities\Options\Option;
use App\Http\Controllers\Controller;

/**
 * Site Options Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class SiteOptionsController extends Controller
{
    public function page1()
    {
        return view('options.page-1', compact('options'));
    }

    public function save1(Request $request)
    {
        $request->validate([
            'money_sign' => 'required|max:3',
        ]);

        $option = Option::firstorNew(['key' => 'money_sign']);
        $option->value = $request->get('money_sign');
        $option->save();

        flash(trans('option.updated'), 'success');

        return redirect()->route('site-options.page-1');
    }
}
