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
        $acconts_sum = $this->getAccountSum($this->accounts);

        if ($this->accounts->isEmpty()) {
            return view('accounts.empty-accounts');
        }

        return view('accounts.index', ['accounts' => $this->accounts, 'acconts_sum' => $acconts_sum]);
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
