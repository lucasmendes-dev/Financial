from django.shortcuts import render, redirect
from django.contrib.auth.decorators import login_required
from django.http import HttpResponse
from .forms import EarningForm
from .models import Earning
from asset.models import Asset
from django.db.models import Sum
from django.db.models.functions import TruncMonth


@login_required
def earning_index(request):
    
    earnings = Earning.objects.annotate(month=TruncMonth('earning_date')).values('month').annotate(valor_total=Sum('total_value'))
    
    return render(request, 'earning.html', {'earnings': earnings})


@login_required
def earning_create(request):
    
    form = EarningForm    

    if request.method == "POST":   
        
        asset_type_id = Asset.objects.get(id=request.POST['asset'])
        total_value_for_asset = float(f"{float(request.POST['earning_value']) * int(request.POST['asset_qty']):.2f}")
        
        earning = Earning(
            asset_qty = request.POST['asset_qty'],
            earning_value = request.POST['earning_value'],
            total_value = total_value_for_asset,
            earning_date = request.POST['earning_date'],
            asset = asset_type_id,
            user = request.user
        )
        
        earning.save()
        
        return redirect('earnings:index')
        
    else:             
        return render(request, 'create_earning.html', {'form': form})


@login_required
def earning_update(request):
    pass


@login_required
def earning_delete(request):
    pass


