<?php

namespace App\Http\Controllers;

use App\Entities\Partners\Customer;
use App\Entities\Payments\Payment;
use App\Entities\Payments\PaymentsRepository;
use App\Http\Requests\Payments\CreateRequest;
use App\Http\Requests\Payments\DeleteRequest;
use App\Http\Requests\Payments\UpdateRequest;
use Illuminate\Http\Request;

/**
 * Payments Controller class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class PaymentsController extends Controller
{
    private $repo;

    public function __construct(PaymentsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $payments = $this->repo->getPayments($request->only('q', 'partner_id'));
        $partnersList = Customer::pluck('name', 'id')->all();

        return view('payments.index', compact('payments', 'partnersList'));
    }

    public function create()
    {
        $projects = $this->repo->getProjectsList();
        $partners = $this->repo->getCustomersAndVendorsList();

        return view('payments.create', compact('projects', 'partners'));
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
        $partners = $this->repo->getCustomersAndVendorsList();

        return view('payments.edit', compact('payment', 'projects', 'partners'));
    }

    public function update(UpdateRequest $request, Payment $payment)
    {
        $payment->update($request->except(['_method', '_token']));

        flash()->success(trans('payment.updated'));

        return redirect()->route('payments.show', $payment->id);
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
