<?php

namespace App\Http\Controllers\References;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Option;

/**
 * Site Options Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class SiteOptionsController extends Controller
{
    public function page1()
    {
        return view('options.page-1');
    }

    public function save1(Request $request)
    {
        $optionData = $request->validate([
            'money_sign'         => 'required|max:3',
            'money_sign_in_word' => 'required|max:15',
        ]);

        Option::set('money_sign', $optionData['money_sign']);
        Option::set('money_sign_in_word', $optionData['money_sign_in_word']);

        flash(__('option.updated'), 'success');

        return redirect()->route('site-options.page-1');
    }
}
