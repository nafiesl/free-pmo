<?php

namespace App\Http\Controllers\Api;

use App\Entities\Payments\Payment;
use App\Entities\Payments\PaymentsRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $repo;

    public function __construct(PaymentsRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $payments = $this->repo->getPayments($request->only('q', 'partner_id'));

        return response()->json($payments, 200);
    }

    public function show(Payment $payment)
    {
        $this->authorize('view', $payment);

        return $payment->load('project', 'partner');
    }

    public function store(Request $request)
    {
        $this->authorize('create', new Payment);

        $paymentData = $request->validate([
            'date' => 'required|date|date_format:Y-m-d',
            'in_out' => 'required|numeric',
            'amount' => 'required',
            'project_id' => 'required|numeric|exists:projects,id',
            'type_id' => 'required|numeric',
            'partner_id' => 'required|numeric',
            'description' => 'required|max:255',
        ]);

        $payment = $this->repo->create($paymentData);

        return response()->json(['message' => __('payment.created'), 'id' => $payment->id], 201);
    }

    public function update(Request $request, Payment $payment)
    {
        $this->authorize('update', $payment);

        $paymentData = $request->validate([
            'date' => 'sometimes|date|date_format:Y-m-d',
            'in_out' => 'sometimes|numeric',
            'amount' => 'sometimes',
            'project_id' => 'sometimes|numeric|exists:projects,id',
            'type_id' => 'sometimes|numeric',
            'partner_id' => 'sometimes|numeric',
            'description' => 'sometimes|max:255',
        ]);

        if (isset($paymentData['amount'])) {
            $paymentData['amount'] = str_replace('.', '', $paymentData['amount']);
        }

        $payment->update($paymentData);

        return response()->json(['message' => __('payment.updated')], 200);
    }

    public function destroy(Payment $payment)
    {
        $this->authorize('delete', $payment);

        $payment->delete();

        return response()->json(['message' => __('payment.deleted')], 200);
    }
}
