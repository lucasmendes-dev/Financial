from django.shortcuts import render, redirect, get_object_or_404
from .forms import StatementForm
from .models import Statement, StatementCategory, StatementType
from account.models import Account
from django.contrib.auth.decorators import login_required
import json


@login_required
def statement_index(request):
    
    statements = Statement.objects.all().filter(user=request.user)
            
    return render(request, 'statement.html', {'statements': statements})


@login_required
def statement_create(request):
    
    form = StatementForm
    
    if request.method == "POST":
        
        #foreinKey treatment
        statement_type_id = StatementType.objects.get(id=request.POST['statement_type'])
        statement_category_id = StatementCategory.objects.get(id=request.POST['statement_category'])
        account_id = Account.objects.get(id=request.POST['account'])
        
        statement = Statement(
            statement_type = statement_type_id,
            statement_description = request.POST['statement_description'],
            statement_value = request.POST['statement_value'],
            statement_date = request.POST['statement_date'],
            statement_category = statement_category_id,
            account = account_id,          
            user = request.user   
        )
        
        statement.save()
        return redirect('statements:index')
        
    else:
        return render(request, 'create_statement.html', {'form': form})   


@login_required
def statement_update(request):
    pass


@login_required
def statement_delete(request, id):
    statement = get_object_or_404(Statement, id=id)
    statement.delete()
    
    return redirect('statements:index')

