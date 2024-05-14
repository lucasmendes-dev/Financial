<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected $accounts;

    public function index()
    {
        $user = Auth::user();
        $this->accounts = Account::where('user_id', $user->id)->get();
        return view('accounts.index', ['accounts' => $this->accounts]);
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

    public function destroy(Account $account)
    {
        //
    }
}
