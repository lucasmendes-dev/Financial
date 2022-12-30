from django.shortcuts import render
from django.http import HttpResponse
from .models import Account, AccountStatement, Category
from django.db.models import Sum


def account_index(request):
    
    accounts = Account.objects.all()
    total_balance = Account.objects.all().aggregate(Sum('account_balance'))['account_balance__sum']

    return render(request, 'index.html', {'accounts': accounts, 'total_balance': total_balance})


def account_create(request):
    pass


def account_update(request):
    pass


def account_delete(request):
    pass


#Auxiliar functions ↓
