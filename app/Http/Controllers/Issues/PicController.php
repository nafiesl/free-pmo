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
            'status_id' => 'required|in:0,1,2,3,4',
            'pic_id'    => 'nullable|exists:users,id',
        ]);
        $issue->status_id = $picData['status_id'];
        $issue->pic_id = $picData['pic_id'];
        $issue->save();

        if ($issue->pic_id) {
            flash(__('issue.pic_assigned'), 'success');
        } else {
            flash(__('issue.pic_removed'), 'warning');
        }

        return back();
    }
}
