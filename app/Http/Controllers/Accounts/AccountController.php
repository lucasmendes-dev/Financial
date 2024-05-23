<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Balance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected $accounts;
    protected $user;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $this->accounts = Account::where('user_id', $this->user->id)->get();

        if ($this->accounts->isEmpty()) {
            return view('accounts.empty-accounts');
        }

        $accounts_sum = array_sum($this->accounts->pluck('balance')->all());
        $account_names = $this->accounts->pluck('name');
        $account_balances = $this->accounts->pluck('balance');

        $balancesPerMonth = $this->getBalancePerMonth();

        return view('accounts.index', [
            'accounts' => $this->accounts, 
            'accounts_sum' => $accounts_sum,
            'account_names' => $account_names,
            'account_balances' => $account_balances,
            'balancesPerMonth' => $balancesPerMonth
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['balance'] = preg_replace('/,(\d+)/', '.$1', $data['balance']);
        $data['user_id'] = $this->user->id;

        Account::create($data);

        if (Balance::where('user_id', $this->user->id)->get()->isEmpty()) {
            $balanceData = [
                'balance' => 0,
                'user_id' => $this->user->id,
                'date' => now()->subMonth()
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
        $this->updateBalanceData();

        $accounts = Account::where('user_id', $this->user->id)->get();
        if ($accounts->isEmpty()) {
            Balance::where('user_id', $this->user->id)->delete();
        }

        return(redirect(route('accounts.index')));
    }

    public function getBalancePerMonth()
    {
        $balances = Balance::where('user_id', $this->user->id)->orderBy('date')->get();

        $grouped = $balances->groupBy(function($item) {
            return Carbon::parse($item->date)->format('M-y');
        });

        $monthlyBalances = $grouped->map(function ($group) {
            return $group->sortByDesc('date')->first();
        });

        $result = $monthlyBalances->map(function ($item) {
            return $item->balance;
        });

        return $result;
    }

    public function updateBalanceData(): void
    {
        $accounts = Account::where('user_id', $this->user->id)->get();
        $accounts_sum = array_sum($accounts->pluck('balance')->all());

        $balanceData = [
            'balance' => $accounts_sum,
            'user_id' => $this->user->id,
            'date' => now()
        ];

        Balance::create($balanceData);
    }
}
