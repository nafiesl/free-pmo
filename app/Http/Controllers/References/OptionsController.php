<?php

namespace App\Http\Controllers\References;

use App\Entities\Options\Option;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            'key' => 'required|max:255|alpha_dash',
            'value' => 'max:255',
        ]);

        $option = Option::create($newOptionData);

        flash()->success(trans('option.created'));
        return redirect()->route('options.index');
    }

    public function destroy(Request $req, $optionId)
    {
        if ($optionId == $req->get('option_id')) {
            Option::findOrFail($optionId)->delete();
            flash()->success(trans('option.deleted'));
        } else {
            flash()->error(trans('option.undeleted'));
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

        flash()->success(trans('option.updated'));
        return redirect()->route('options.index');
    }

}
