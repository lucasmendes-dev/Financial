from django.shortcuts import render, redirect, get_object_or_404
from django.http import HttpResponse
from django import forms
from .models import Asset, AssetTransaction, AssetType
from .forms import AssetForm
from account.models import Account
from account.forms import AccountForm
import requests


def asset_index(request):
    
    stocks = Asset.objects.all().filter(user=request.user, status=1, asset_type=1)  
    reit = Asset.objects.all().filter(user=request.user, status=1, asset_type=2)       
    
    if not stocks and not reit:
        return render(request, 'asset.html')
    
    if stocks:        
        stocks_tickers = getAssetTicker(stocks)        
               
        stocks_api_url =  f'https://brapi.dev/api/quote/{stocks_tickers}?range=1d&interval=1d&fundamental=false'                
        stocks_data = requests.get(stocks_api_url).json()       
        
        stocks_current_price = getCurrentPrice(stocks_data)                
        stocks_daily_percent_variation = getDailyPercentVariation(stocks_data)                
        stocks_daily_value_variation = getDailyValueVariation(stocks_data, stocks)
                         
        stocks_total_percent_variation = getTotalPercentVariation(stocks, stocks_current_price)
        stocks_total_value_variation = getTotalValueVariation(stocks, stocks_current_price)    
        stocks_amount = getFullAssetAmount(stocks, stocks_current_price)            
          
        stocks_list = zip(stocks, stocks_current_price, stocks_daily_percent_variation, stocks_daily_value_variation, stocks_total_percent_variation, stocks_total_value_variation, stocks_amount)
    else:
        stocks_list = ""
        
        
    if reit:        
        reit_tickers = getAssetTicker(reit) 
        
        reit_api_url =  f'https://brapi.dev/api/quote/{reit_tickers}?range=1d&interval=1d&fundamental=false'
        reit_data = requests.get(reit_api_url).json() 
          
        reit_current_price = getCurrentPrice(reit_data)
        reit_daily_percent_variation = getDailyPercentVariation(reit_data)
        reit_daily_value_variation = getDailyValueVariation(reit_data, stocks)
        
        reit_total_percent_variation = getTotalPercentVariation(reit, reit_current_price)
        reit_total_value_variation = getTotalValueVariation(reit, reit_current_price)
        reit_amount = getFullAssetAmount(reit, reit_current_price) 
        
        reit_list = zip(reit, reit_current_price, reit_daily_percent_variation, reit_daily_value_variation, reit_total_percent_variation, reit_total_value_variation, reit_amount) 
    else:
        reit_list = ""
        
    context = {
        'stocks_list': stocks_list,   
        'reit_list': reit_list      
    }                              
            
    return render(request, 'asset.html', context)
        


def asset_create(request):
    
    form = AssetForm
    accounts = Account.objects.all().filter(user=request.user)

    if request.method == "POST":
        
        asset_type_id = AssetType.objects.get(id=request.POST['asset_type'])
        
        asset = Asset(
            asset_type = asset_type_id,
            asset_name = request.POST['asset_name'],
            asset_code = request.POST['asset_code'],
            asset_qty = request.POST['asset_qty'],
            average_price = request.POST['average_price'],
            status = request.POST['status'],
            account_id = request.POST['account_id'],
            user = request.user
        )
        
        asset.save()
        
        #adding value from asset in Account registred
        account = get_object_or_404(Account, id=request.POST['account_id'])
                
        asset_api = f"https://brapi.dev/api/quote/{request.POST['asset_code']}?range=1d&interval=1d&fundamental=false"
        asset_today = requests.get(asset_api).json()     
        
        new_qty = int(request.POST['asset_qty'])
        new_balance = getCurrentPrice(asset_today)[0]
        
        account.account_balance += float(f'{new_qty * new_balance:.2f}')
        account.save()
        
        return redirect('assets:index')
        
    else:             
        return render(request, 'create_asset.html', {'form': form, 'accounts': accounts})


def asset_update(request, id):
    
    asset = get_object_or_404(Asset, id=id)
    accounts = Account.objects.all().filter(user=request.user)
    form = AssetForm(instance=asset)
    
    if request.method == "POST":
                
        form = AssetForm(request.POST, instance=asset)
        if(form.is_valid()):
            asset.save()
                        
            return redirect('assets:index')
        else:            
            return render(request, 'asset.html', {'form': form, 'asset': asset})
    else:
        return render(request, 'update_asset.html', {'form': form, 'asset': asset, 'accounts': accounts})


def asset_delete(request, id):
    
    asset = get_object_or_404(Asset, id=id)
    asset.delete()
    
    return redirect('assets:index')


#Auxiliar functions ↓

def getAssetTicker(assets: Asset):    
    tickers = ""
    for i, code in enumerate(assets):
        if (i + 1) < len(assets):
            tickers+= code.asset_code + "%2C"
        else:
            tickers+= code.asset_code

    return tickers

def getCurrentPrice(data):
    current_price = []
    for value in data['results']:
        current_price.append(float(f"{value['regularMarketPrice']:.2f}"))     
    
    return current_price


def getDailyPercentVariation(data):
    daily_percent_variation = []
    for value in data['results']:
        daily_percent_variation.append(float(f"{value['regularMarketChangePercent']:.2f}"))      
    
    return daily_percent_variation
          
            
def getDailyValueVariation(data, assets):
    asset_value_variation = []    
    daily_value_variation = []
    for day_value in data['results']:
        asset_value_variation.append(float(f"{day_value['regularMarketChange']:.2f}"))

    array = zip(assets, asset_value_variation)
    for asset, asset_value_variation in array:

        variation = asset_value_variation * asset.asset_qty
        daily_value_variation.append(float(f"{variation:.2f}"))

    return daily_value_variation


def getTotalPercentVariation(assets, current_price):
    total_percente_variation = []
    array = zip(assets, current_price)    
    for asset, price in array:
        value = (price - asset.average_price) * 100 / asset.average_price  
        total_percente_variation.append(float(f'{value:.2f}'))
        
    return total_percente_variation


def getTotalValueVariation(assets, daily_value_variation):
    total_value_variation = []
    array = zip(assets, daily_value_variation)    
    for asset, variation in array:
        value = (variation - asset.average_price) * asset.asset_qty
        total_value_variation.append(float(f'{value:.2f}'))
        
    return total_value_variation



def getFullAssetAmount(assets, current_price):
    full_asset_amount = []
    array = zip(assets, current_price)    
    for asset, price in array:
        value = price * asset.asset_qty
        full_asset_amount.append(float(f'{value:.2f}'))
        
    return full_asset_amount