<?php

namespace App\Http\Controllers;

use App\Entities\Payments\Payment;
use App\Entities\Payments\PaymentsRepository;
use App\Entities\Users\User;
use App\Http\Requests\Payments\CreateRequest;
use App\Http\Requests\Payments\DeleteRequest;
use App\Http\Requests\Payments\UpdateRequest;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    private $repo;

    public function __construct(PaymentsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $payments = $this->repo->getPayments($request->only('q', 'customer_id'));
        $usersList = User::pluck('name', 'id')->all();
        return view('payments.index', compact('payments', 'usersList'));
    }

    public function create()
    {
        $projects = $this->repo->getProjectsList();
        $customers = $this->repo->getCustomersAndVendorsList();
        return view('payments.create', compact('projects', 'customers'));
    }

    public function store(CreateRequest $request)
    {
        $payment = $this->repo->create($request->except('_token'));
        flash()->success(trans('payment.created'));
        return redirect()->route('projects.payments', $payment->project_id);
    }

    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $projects = $this->repo->getProjectsList();
        $customers = $this->repo->getCustomersAndVendorsList();
        return view('payments.edit', compact('payment', 'projects', 'customers'));
    }

    public function update(UpdateRequest $request, $paymentId)
    {
        $payment = $this->repo->update($request->except(['_method','_token']), $paymentId);
        flash()->success(trans('payment.updated'));
        return redirect()->route('payments.show', $paymentId);
    }

    public function delete(Payment $payment)
    {
        return view('payments.delete', compact('payment'));
    }

    public function destroy(DeleteRequest $request, Payment $payment)
    {
        $projectId = $payment->project_id;
        if ($payment->id == $request->get('payment_id')) {
            $payment->delete();
            flash()->success(trans('payment.deleted'));
        } else {
            flash()->error(trans('payment.undeleted'));
        }

        return redirect()->route('projects.payments', $projectId);
    }

    public function pdf(Payment $payment)
    {
        return view('payments.pdf', compact('payment'));
    }
}
