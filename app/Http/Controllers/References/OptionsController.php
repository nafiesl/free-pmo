<?php

namespace App\Http\Controllers\References;

use Illuminate\Http\Request;
use App\Entities\Options\Option;
use App\Http\Controllers\Controller;

class OptionsController extends Controller
{
    public function index(Request $req)
    {
        $options = Option::all();
        $editableOption = null;

        if (in_array($req->get('action'), ['del', 'edit']) && $req->has('id')) {
            $editableOption = Option::findOrFail($req->get('id'));
        }

        return view('options.index', compact('options', 'editableOption'));
    }

    public function store(Request $req)
    {
        $newOptionData = $req->validate([
            'key'   => 'required|max:255|alpha_dash',
            'value' => 'max:255',
        ]);

        $option = Option::create($newOptionData);

        flash(trans('option.created'), 'success');

        return redirect()->route('options.index');
    }

    public function destroy(Request $req, $optionId)
    {
        if ($optionId == $req->get('option_id')) {
            Option::findOrFail($optionId)->delete();
            flash(trans('option.deleted'), 'success');
        } else {
            flash(trans('option.undeleted'), 'danger');
        }

        return redirect()->route('options.index');
    }

    public function save(Request $req)
    {
        $options = Option::all();
        foreach ($req->except(['_method', '_token']) as $key => $value) {
            $option = $options->where('key', $key)->first();
            $option->value = $value;
            $option->save();
        }

        flash(trans('option.updated'), 'success');

        return redirect()->route('options.index');
    }
}
