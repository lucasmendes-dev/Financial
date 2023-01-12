from django.shortcuts import render, redirect, get_object_or_404
from django.http import HttpResponse
from .models import Account, AccountStatement, Category, AccountType
from .forms import AccountForm
from django.db.models import Sum
import json
from django.contrib.auth.decorators import login_required


@login_required
def account_index(request):
    
    accounts = Account.objects.all().filter(user=request.user)
    total_balance = Account.objects.all().filter(user=request.user).aggregate(Sum('account_balance'))['account_balance__sum']
    total_balance = f"{total_balance:.2f}"
    
    #for Chart.Js data
    accounts_data = []
    for account in accounts:
        accounts_data.append({'name': account.account_name, 'balance': account.account_balance})
        
    accounts_data_json = json.dumps(accounts_data)

    return render(request, 'index.html', {'accounts': accounts, 'total_balance': total_balance, 'accounts_data_json': accounts_data_json})


@login_required
def account_create(request):
    
    if request.method == "POST":
        
        account_type_id = AccountType.objects.get(id=request.POST['account_type'])
        
        account = Account(
            account_type = account_type_id,
            account_name = request.POST['account_name'],
            account_balance = request.POST['account_balance'],
            user = request.user
        )
        
        account.save()
        return redirect('accounts:index')
        
    else:        
        return render(request, 'index.html')


@login_required
def account_update(request, id):
    
    account = get_object_or_404(Account, id=id)
    form = AccountForm(instance=account)

    if(request.method == "POST"):
        form = AccountForm(request.POST, instance=account)
        if(form.is_valid()):
            account.save()
                        
            return redirect('accounts:index')
        else:            
            return render(request, 'index.html', {'form': form, 'account': account})
    else:        
        return render(request, 'update.html', {'form': form, 'account': account})


@login_required
def account_delete(request, id):
    account = get_object_or_404(Account, id=id)
    account.delete()
    
    return redirect('accounts:index')


#Auxiliar functions ↓
