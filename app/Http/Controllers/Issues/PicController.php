<?php

namespace App\Http\Controllers\Issues;

use Illuminate\Http\Request;
use App\Entities\Projects\Issue;
use App\Http\Controllers\Controller;

class PicController extends Controller
{
    public function update(Request $request, Issue $issue)
    {
        $picData = $request->validate([
            'pic_id' => 'nullable|exists:users,id',
        ]);
        $issue->pic_id = $picData['pic_id'];
        $issue->save();

        flash(__('issue.pic_assigned'), 'success');

        return back();
    }
}
