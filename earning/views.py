from django.shortcuts import render, redirect
from django.contrib.auth.decorators import login_required
from django.http import HttpResponse
from .forms import EarningForm
from .models import Earning
from datetime import datetime


@login_required
def earning_index(request):
    return render(request, 'earning.html')


def earning_create(request):
    
    form = EarningForm    

    if request.method == "POST":        

        earning = Earning(
            asset_qty = request.POST['asset_qty'],
            earning_value = request.POST['earning_value'],
            earning_date = datetime.now(),
            asset = request.POST['asset_code'],
            user = request.user
        )
        
        earning.save()
        
        return redirect('earnings:index')
        
    else:             
        return render(request, 'create_earning.html', {'form': form})


def earning_update(request):
    pass


def earning_delete(request):
    pass


