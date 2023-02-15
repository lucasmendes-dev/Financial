from django.shortcuts import render, redirect, get_object_or_404
from django.http import HttpResponse
from .forms import StatementForm
from .models import Statement, StatementCategory, StatementType
from account.models import Account
from django.contrib.auth.decorators import login_required
import json
from django.db.models import Sum


@login_required
def statement_index(request):
    
    statements = Statement.objects.all().filter(user=request.user)
    entrance = statements.filter(statement_type=1).aggregate(Sum('statement_value'))['statement_value__sum'] or 0
    exit = statements.filter(statement_type=2).aggregate(Sum('statement_value'))['statement_value__sum'] or 0              
    
    result = f'{entrance - exit :.2f}'
        
    spending_by_category = statements.exclude(statement_category=10).values('statement_category').annotate(total_value=Sum('statement_value'))                    
    
    for spending in spending_by_category:
        category_name = StatementCategory.objects.filter(id=spending["statement_category"]).values('statement_category')
        spending["statement_category"] = category_name[0]["statement_category"]
    
    
    return render(request, 'statement.html', {'statements': statements, 'entrance': entrance, 'exit': exit, 'result': result, 'spending_by_category': json.dumps(list(spending_by_category))})


@login_required
def statement_create(request):
    
    form = StatementForm
    account_form = Account.objects.all().filter(user=request.user)
    
    if request.method == "POST":

        #foreinKey treatment
        statement_type_id = StatementType.objects.get(id=request.POST['statement_type'])        
        account_id = Account.objects.get(id=request.POST['account'])
        statement_category_id = StatementCategory.objects.get(id=request.POST['statement_category']) if request.POST['statement_category'] else ""
        
        statement = Statement(
            statement_type = statement_type_id,
            statement_description = request.POST['statement_description'],
            statement_value = request.POST['statement_value'],
            statement_date = request.POST['statement_date'],
            statement_category = statement_category_id,
            account = account_id,     
            destiny_account = request.POST['destiny_account'] if request.POST['destiny_account'] else None,     
            user = request.user   
        )
        
        statement.save()
        
        
        #To change the value from Account        
        account = get_object_or_404(Account, id=request.POST['account'], user=request.user)
             
        if request.POST["statement_type"] == "1":   #entrance
            account.account_balance += float(request.POST['statement_value'])
            
        elif request.POST["statement_type"] == "2":  #exit
            account.account_balance -= float(request.POST['statement_value'])
            
        else:  #transfer
            destiny_account = get_object_or_404(Account, id=request.POST['destiny_account'], user=request.user)
        
            account.account_balance -= float(request.POST['statement_value'])
            destiny_account.account_balance += float(request.POST['statement_value'])
            
            destiny_account.save()   
            
        account.save()
                     
        
        return redirect('statements:index')
        
    else:
        return render(request, 'create_statement.html', {'form': form, 'account_form': account_form})   


@login_required
def statement_update(request, id):
    statement = get_object_or_404(Statement, id=id)
    form = StatementForm(instance=statement)
    
    if request.method == "POST":
        
        form = StatementForm(request.POST, instance=statement)
        if form.is_valid():
            form.save()
            
            return redirect('statements:index')
        else:
            return render(request, 'statement.html', {'form': form ,'statement': statement})
        
        
    else:
        return render(request, 'update_statement.html', {'form': form , 'statement': statement})


@login_required
def statement_delete(request, id):
    
    statement = get_object_or_404(Statement, id=id)
    account = get_object_or_404(Account, id=statement.account_id, user=request.user)
    destiny_account = get_object_or_404(Account, id=statement.destiny_account, user=request.user) if statement.destiny_account else None
    
    if statement.statement_type == "3":  #transfer
        account.account_balance += float(statement.statement_value)
        destiny_account.account_balance -= float(statement.statement_value)
        destiny_account.save()
        
    else:
        account.account_balance -= float(statement.statement_value)
    
    account.save()    
    statement.delete()
    
    return redirect('statements:index')

