<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected $accounts;

    public function index()
    {
        $user = Auth::user();
        $this->accounts = Account::where('user_id', $user->id)->get();
        $accounts_sum = $this->getAccountSum($this->accounts);

        if ($this->accounts->isEmpty()) {
            return view('accounts.empty-accounts');
        }

        $account_names = $this->accounts->pluck('name');
        $account_balances = $this->accounts->pluck('balance');

        return view('accounts.index', [
            'accounts' => $this->accounts, 
            'accounts_sum' => $accounts_sum,
            'account_names' => $account_names,
            'account_balances' => $account_balances
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        $data['balance'] = preg_replace('/,(\d+)/', '.$1', $data['balance']);
        $data['user_id'] = $user->id;

        Account::create($data);
        return redirect(route('accounts.index'));
    }

    public function edit(string $id)
    {
        $account = Account::findOrFail($id);
        
        return view('accounts.edit', compact('account'));
    }

    public function update(Request $request, string $id)
    {
        $account = Account::findOrFail($id);
        $account->update($request->all());

        return redirect(route('accounts.index'));
    }

    public function destroy(string $id)
    {
        $account = Account::findOrFail($id);
        $account->delete();

        return(redirect(route('accounts.index')));
    }

    public function getAccountSum(Collection $accounts)
    {
        $allBalance = $this->accounts->pluck('balance')->all();
        return array_sum($allBalance);
    }
}
