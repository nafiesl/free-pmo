<?php

namespace App\Http\Controllers;

use App\Entities\Partners\Customer;
use App\Entities\Payments\Payment;
use App\Entities\Payments\PaymentsRepository;
use App\Entities\Projects\Project;
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
    /**
     * @var \App\Entities\Payments\PaymentsRepository
     */
    private $repo;

    /**
     * Create new Payments Controller.
     *
     * @param  \App\Entities\Payments\PaymentsRepository  $repo
     */
    public function __construct(PaymentsRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Show payment list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $payments = $this->repo->getPayments($request->only('q', 'partner_id'));
        $partnersList = Customer::pluck('name', 'id')->all();

        return view('payments.index', compact('payments', 'partnersList'));
    }

    /**
     * Show create payment form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $projects = $this->getProjectsList();
        $partners = $this->getCustomersAndVendorsList();
        $project = Project::find(request('project_id'));

        return view('payments.create', compact('projects', 'partners', 'project'));
    }

    /**
     * Store new payment to database.
     *
     * @param  \App\Http\Requests\Payments\CreateRequest  $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(CreateRequest $request)
    {
        $payment = $this->repo->create($request->except('_token'));
        flash(__('payment.created'), 'success');

        return redirect()->route('projects.payments', $payment->project_id);
    }

    /**
     * Show a payment detail.
     *
     * @param  \App\Entities\Payments\Payment  $payment
     * @return \Illuminate\View\View
     */
    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    /**
     * Show a payment edit form.
     *
     * @param  \App\Entities\Payments\Payment  $payment
     * @return \Illuminate\View\View
     */
    public function edit(Payment $payment)
    {
        $projects = $this->getProjectsList();

        if ($payment->partner_type == 'App\Entities\Users\User') {
            $partners = $this->repo->getWorkersList();
        } elseif ($payment->partner_type == 'App\Entities\Partners\Customer') {
            $partners = [__('customer.customer') => $this->repo->getCustomersList()];
        } else {
            $partners = [__('vendor.vendor') => $this->getVendorsList()];
        }

        return view('payments.edit', compact('payment', 'projects', 'partners'));
    }

    /**
     * Update a payment on database.
     *
     * @param  \App\Http\Requests\Payments\UpdateRequest  $request
     * @param  \App\Entities\Payments\Payment  $payment
     * @return \Illuminate\Routing\Redirector
     */
    public function update(UpdateRequest $request, Payment $payment)
    {
        $paymentData = $request->validated();

        if ($paymentData['in_out'] == 0) {
            if (isset($paymentData['partner_type']) && $paymentData['partner_type'] == 'users') {
                $paymentData['partner_type'] = 'App\Entities\Users\User';
            } else {
                $paymentData['partner_type'] = 'App\Entities\Partners\Vendor';
            }
        } else {
            $paymentData['partner_type'] = 'App\Entities\Partners\Customer';
        }

        $payment->update($paymentData);

        flash(__('payment.updated'), 'success');

        return redirect()->route('payments.show', $payment->id);
    }

    /**
     * Show payment delete confirmation page.
     *
     * @param  \App\Entities\Payments\Payment  $payment
     * @return \Illuminate\View\View
     */
    public function delete(Payment $payment)
    {
        return view('payments.delete', compact('payment'));
    }

    /**
     * Delete a payment from database.
     *
     * @param  \App\Http\Requests\Payments\DeleteRequest  $paymentDeleteRequest
     * @param  \App\Entities\Payments\Payment  $payment
     * @return \Illuminate\Routing\Redirector
     */
    public function destroy(DeleteRequest $request, Payment $payment)
    {
        $projectId = $payment->project_id;
        if ($payment->id == $request->get('payment_id')) {
            $payment->delete();
            flash(__('payment.deleted'), 'success');
        } else {
            flash(__('payment.undeleted'), 'danger');
        }

        return redirect()->route('projects.payments', $projectId);
    }

    /**
     * Print payment receipt.
     *
     * @param  \App\Entities\Payments\Payment  $payment
     * @return \Illuminate\View\View
     */
    public function pdf(Payment $payment)
    {
        return view('payments.pdf', compact('payment'));
    }
}
