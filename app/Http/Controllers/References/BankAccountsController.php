<?php

namespace App\Http\Controllers\References;

use App\Entities\Options\Option;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Bank Account Controller.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class BankAccountsController extends Controller
{
    /**
     * Display a listing of the bankAccount.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $editableBankAccount = null;
        $bankAccounts = Option::where('key', 'bank_accounts')->first();

        if (!is_null($bankAccounts)) {
            $bankAccounts = $bankAccounts->value;
            $bankAccounts = json_decode($bankAccounts, true);
            $bankAccounts = collect($bankAccounts)
                ->map(function ($bankAccount) {
                    return (object) $bankAccount;
                });

            if (in_array(request('action'), ['edit', 'delete']) && request('id') != null) {
                $editableBankAccount = $bankAccounts[request('id')];
            }
        } else {
            $bankAccounts = collect([]);
        }

        return view('bank-accounts.index', compact('bankAccounts', 'editableBankAccount'));
    }

    /**
     * Store a newly created bank account in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newBankAccount = $request->validate([
            'name'         => 'required|max:60',
            'number'       => 'required|max:60',
            'account_name' => 'required|max:60',
            'description'  => 'nullable|max:255',
        ]);

        $option = Option::firstOrNew(['key' => 'bank_accounts']);
        if ($option->exists) {
            $bankAccounts = $option->value;
            $bankAccounts = json_decode($bankAccounts, true);
            if ($bankAccounts == []) {
                $bankAccounts[1] = $newBankAccount;
            } else {
                $bankAccounts[] = $newBankAccount;
            }
        } else {
            $bankAccounts = [];
            $bankAccounts[1] = $newBankAccount;
        }

        $bankAccounts = json_encode($bankAccounts);

        $option->value = $bankAccounts;
        $option->save();

        flash(trans('bank_account.created'), 'success');

        return redirect()->route('bank-accounts.index');
    }

    /**
     * Update the specified bank account in storage.
     *
     * @param \Illuminate\Http\Request           $request
     * @param \App\Entities\Invoices\BankAccount $bankAccount
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bankAccountId)
    {
        $bankAccountData = $request->validate([
            'name'         => 'required|max:60',
            'number'       => 'required|max:60',
            'account_name' => 'required|max:60',
            'description'  => 'nullable|max:255',
        ]);

        $bankAccounts = Option::where('key', 'bank_accounts')->first();

        $bankAccounts = $bankAccounts->value;
        $bankAccounts = json_decode($bankAccounts, true);

        $bankAccounts[$bankAccountId] = $bankAccountData;

        $bankAccounts = json_encode($bankAccounts);

        $option = Option::where('key', 'bank_accounts')->first();
        $option->value = $bankAccounts;
        $option->save();

        flash(trans('bank_account.updated'), 'success');

        return redirect()->route('bank-accounts.index');
    }

    /**
     * Remove the specified bank account from storage.
     *
     * @param \App\Entities\Invoices\BankAccount $bankAccount
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($bankAccountId)
    {
        request()->validate([
            'bank_account_id' => 'required',
        ]);

        if (request('bank_account_id') == $bankAccountId) {
            $bankAccounts = Option::where('key', 'bank_accounts')->first();

            $bankAccounts = $bankAccounts->value;
            $bankAccounts = json_decode($bankAccounts, true);

            unset($bankAccounts[$bankAccountId]);

            $bankAccounts = json_encode($bankAccounts);

            $option = Option::where('key', 'bank_accounts')->first();
            $option->value = $bankAccounts;
            $option->save();

            flash(trans('bank_account.deleted'), 'success');

            return redirect()->route('bank-accounts.index');
        }

        return back();
    }
}
