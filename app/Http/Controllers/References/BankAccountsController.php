<?php

namespace App\Http\Controllers\References;

use App\Entities\Invoices\BankAccount;
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
     * Display a listing of the bank account.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $editableBankAccount = null;
        $bankAccounts = BankAccount::all();

        if (in_array(request('action'), ['edit', 'delete']) && request('id') != null) {
            $editableBankAccount = BankAccount::find(request('id'));
        }

        return view('bank-accounts.index', compact('bankAccounts', 'editableBankAccount'));
    }

    /**
     * Store a newly created bank account in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $newBankAccount = $request->validate([
            'name' => 'required|max:60',
            'number' => 'required|max:60',
            'account_name' => 'required|max:60',
            'description' => 'nullable|max:255',
        ]);

        BankAccount::create($newBankAccount);

        flash(__('bank_account.created'), 'success');

        return redirect()->route('bank-accounts.index');
    }

    /**
     * Update the specified bank account in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Invoices\BankAccount  $bankAccount
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, BankAccount $bankAccount)
    {
        $bankAccountData = $request->validate([
            'name' => 'required|max:60',
            'number' => 'required|max:60',
            'account_name' => 'required|max:60',
            'description' => 'nullable|max:255',
            'is_active' => 'required|in:0,1',
        ]);

        $bankAccount->update($bankAccountData);

        flash(__('bank_account.updated'), 'success');

        return redirect()->route('bank-accounts.index');
    }

    /**
     * Remove the specified bank account from storage.
     *
     * @param  \App\Entities\Invoices\BankAccount  $bankAccount
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(BankAccount $bankAccount)
    {
        request()->validate([
            'bank_account_id' => 'required',
        ]);

        if (request('bank_account_id') == $bankAccount->id && $bankAccount->delete()) {
            flash(__('bank_account.deleted'), 'success');

            return redirect()->route('bank-accounts.index');
        }

        return back();
    }

    /**
     * Import bank account from site_options table.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function import()
    {
        $bankAccounts = Option::where('key', 'bank_accounts')->first();
        if ($bankAccounts && $bankAccounts->value) {
            $bankAccountList = json_decode($bankAccounts->value, true);
            foreach ($bankAccountList as $bankAccountData) {
                $bankAccount = new BankAccount($bankAccountData);
                $bankAccount->save();
            }
            $bankAccounts->delete();
            flash(__('bank_account.imported', ['count' => count($bankAccountList)]), 'success');
        }

        return back();
    }
}
