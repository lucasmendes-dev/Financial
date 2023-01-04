from django.shortcuts import render, redirect, get_object_or_404
from django.http import HttpResponse
from .models import Account, AccountStatement, Category, AccountType
from django.db.models import Sum


def account_index(request):
    
    accounts = Account.objects.all()
    total_balance = Account.objects.all().aggregate(Sum('account_balance'))['account_balance__sum']

    return render(request, 'index.html', {'accounts': accounts, 'total_balance': total_balance})


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
        return render(request, 'create.html')


def account_update(request):
    return render(request, 'update.html')


def account_delete(request, id):
    account = get_object_or_404(Account, id=id)
    account.delete()
    
    return redirect('accounts:index')


#Auxiliar functions ↓
