<?php

namespace App\Http\Controllers\Projects;

use App\Entities\Payments\Payment;
use App\Entities\Projects\Project;
use App\Entities\Users\User;
use App\Http\Controllers\Controller;

/**
 * Project Fees Controller.
 *
 * @author Nafies Luthfi <nafiesl@gmail.com>
 */
class FeesController extends Controller
{
    public function create(Project $project)
    {
        $this->authorize('create', new Payment);

        $partners = User::pluck('name', 'id')->all();

        return view('projects.fees.create', compact('project', 'partners'));
    }

    public function store(Project $project)
    {
        $this->authorize('create', new Payment);

        $newPaymentData = request()->validate([
            'type_id'     => 'required|numeric',
            'date'        => 'required|date',
            'amount'      => 'required|numeric',
            'partner_id'  => 'required|exists:users,id',
            'description' => 'required|string',
        ]);
        $newPaymentData['in_out'] = 0;
        $newPaymentData['project_id'] = $project->id;
        $newPaymentData['partner_type'] = User::class;

        Payment::create($newPaymentData);

        flash()->success(trans('payment.created'));

        return redirect()->route('projects.payments', $project->id);
    }
}
