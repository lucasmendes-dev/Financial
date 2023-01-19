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
        
        #iniciando vetores para armazenar dados
        preco_atual = []    
        variacao_diaria = []
        valor_diario = []
        valor_dia = []        
        variacao = [] 
        variacao_total = []
        patrimonio = []
        
        tickers = getAssetTicker(assets)        
        url =  f'https://brapi.dev/api/quote/{tickers}?range=1d&interval=1d&fundamental=false'

        data = requests.get(url).json()        

        #populando os vetores com dados 
        for valor in data['results']:
            preco_atual.append(valor['regularMarketPrice'])              
            variacao_diaria.append(float(f"{valor['regularMarketChangePercent']:.2f}"))      
            valor_diario.append(float(f"{valor['regularMarketChange']:.2f}"))      
            
     
        #realizando operações para tratar os dados antes de ir pro template
        my_list = zip(assets, preco_atual, valor_diario)  
                           
        for asset, cotacao, valor_diario in my_list:
            
            result_percent = (cotacao - asset.average_price) * 100 / asset.average_price  #cálculo da variação em % (Variação)
            result_variacao = (cotacao - asset.average_price) * asset.asset_qty #calculo da variação total em R$ (Variação Total)
            result_valor_dia = valor_diario * asset.asset_qty #calculo da variação diária em R$ (Variação/dia)
            valor_patrimonio = cotacao * asset.asset_qty
                        
            variacao.append(float(f'{result_percent:.2f}'))
            variacao_total.append(float(f'{result_variacao:.2f}'))
            valor_dia.append(float(f'{result_valor_dia:.2f}'))
            patrimonio.append(float(f'{valor_patrimonio:.2f}'))
                    
        
        #zip de todas as informações para enviar pro template    
        table_list = zip(assets, preco_atual, variacao_diaria, valor_dia, variacao, variacao_total, patrimonio)
 
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