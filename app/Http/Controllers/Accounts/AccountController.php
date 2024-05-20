<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Balance;
use App\Models\User;
use Carbon\Carbon;
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

        if ($this->accounts->isEmpty()) {
            return view('accounts.empty-accounts');
        }

        $accounts_sum = array_sum($this->accounts->pluck('balance')->all());
        $account_names = $this->accounts->pluck('name');
        $account_balances = $this->accounts->pluck('balance');

        $balances = $this->getBalancePerMonth();

        return view('accounts.index', [
            'accounts' => $this->accounts, 
            'accounts_sum' => $accounts_sum,
            'account_names' => $account_names,
            'account_balances' => $account_balances,
            'balances' => $balances
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();

        $data['balance'] = preg_replace('/,(\d+)/', '.$1', $data['balance']);
        $data['user_id'] = $user->id;

        Account::create($data);

        if (Balance::where('user_id', $user->id)->get()->isEmpty()) {
            $balanceData = [
                'balance' => 0,
                'user_id' => $user->id,
                'created_at' => now()->subMonth(),
                'updated_at' => now()->subMonth()
            ];
            Balance::create($balanceData);
        }

        $this->updateBalanceData();
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
        $this->updateBalanceData();

        return redirect(route('accounts.index'));
    }

    public function destroy(string $id)
    {
        $account = Account::findOrFail($id);
        $account->delete();

        return(redirect(route('accounts.index')));
    }

    public function getBalancePerMonth()
    {

        $balances = Balance::orderBy('updated_at')->get();

        $grouped = $balances->groupBy(function($item) {
            return Carbon::parse($item->updated_at)->format('M-y');
        });

        $monthlyBalances = $grouped->map(function ($group) {
            return $group->sortByDesc('updated_at')->last();
        });

        $result = $monthlyBalances->map(function ($item) {
            return $item->balance;
        });

        return $result;
    }

    public function updateBalanceData(): void
    {
        $user = Auth::user();
        $accounts = Account::where('user_id', $user->id)->get();
        $accounts_sum = array_sum($accounts->pluck('balance')->all());

        $balanceData = [
            'balance' => $accounts_sum,
            'user_id' => $user->id,
            'created_at' => now(),
            'updated_at' => now()
        ];

        Balance::create($balanceData);
    }
}
