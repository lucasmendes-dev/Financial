from django.shortcuts import render, redirect, get_object_or_404
from django.http import HttpResponse
from django import forms
from .models import Asset, AssetTransaction
from .forms import AssetForm
from account.models import Account
from account.forms import AccountForm
import requests


def asset_index(request):
    
    assets = Asset.objects.all().filter(user=request.user)        
    
    if assets:
                
        valor_dia = []        
        patrimonio = []
        
        tickers = getAssetTicker(assets) 
               
        api_url =  f'https://brapi.dev/api/quote/{tickers}?range=1d&interval=1d&fundamental=false'
        data = requests.get(api_url).json()        

        current_price = getCurrentPrice(data)
        daily_percent_variation = getDailyPercentVariation(data)
        daily_value_variation = getDailyValueVariation(data, assets)
         
        total_percent_variation = getTotalPercentVariation(assets, current_price)
        total_value_variation = getTotalValueVariation(assets, current_price)
        
        asset_amount = getFullAssetAmount(assets, current_price)
        
        
        
        #realizando operações para tratar os dados antes de ir pro template
        my_list = zip(assets, current_price, daily_value_variation)  
                           
        for asset, cotacao, daily_value_variation in my_list:
                    
            result_valor_dia = daily_value_variation * asset.asset_qty #calculo da variação diária em R$ (Variação/dia)
            valor_patrimonio = cotacao * asset.asset_qty
                        
            valor_dia.append(float(f'{result_valor_dia:.2f}'))
            patrimonio.append(float(f'{valor_patrimonio:.2f}'))
                    
        #print(valor_dia)
        #return HttpResponse("olha o print")   
        #zip de todas as informações para enviar pro template    
        table_list = zip(assets, current_price, daily_percent_variation, daily_value_variation, total_percent_variation, total_value_variation, asset_amount)
 
        context = {
            'table_list': table_list,            
        }                              
                
        return render(request, 'asset.html', context)
    
    else:
        return render(request, 'asset.html')


def asset_create(request):
    
    form = AssetForm
    accounts = Account.objects.all().filter(user=request.user)

    if request.method == "POST":
        
        asset = Asset(
            asset_type = request.POST['asset_type'],
            asset_name = request.POST['asset_name'],
            asset_code = request.POST['asset_code'],
            asset_qty = request.POST['asset_qty'],
            average_price = request.POST['average_price'],
            status = request.POST['status'],
            account_id = request.POST['account_id'],
            user = request.user
        )
        
        asset.save()
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
        current_price.append(value['regularMarketPrice'])   
    
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
        daily_value_variation.append(float(f"{variation}"))
    
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
        total_value_variation.append(value)
        
    return total_value_variation



def getFullAssetAmount(assets, current_price):
    full_asset_amount = []
    array = zip(assets, current_price)    
    for asset, price in array:
        value = price * asset.asset_qty
        full_asset_amount.append(float(f'{value}'))
        
    return full_asset_amount