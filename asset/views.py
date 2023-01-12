from django.shortcuts import render, redirect
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
        
        #para gerar a url com todos os tickers do usuário
        key = ""
        for i, cod in enumerate(assets):
            if (i + 1) < len(assets):
                key+= cod.asset_code + "%2C"
            else:
                key+= cod.asset_code
            
        #requisição da API com os tickers de cada ativo do usuário
        url =  f'https://brapi.dev/api/quote/{key}?range=1d&interval=1d&fundamental=false'
        r = requests.get(url)
        data = r.json()
                    
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
                        
            variacao.append(float(f'{result_percent:.2f}'))
            variacao_total.append(float(f'{result_variacao:.2f}'))
            valor_dia.append(float(f'{result_valor_dia:.2f}'))
                    
        
        #zip de todas as informações para enviar pro template    
        table_list = zip(assets, preco_atual, variacao_diaria, valor_dia, variacao, variacao_total)
        
        context = {
            'table_list': table_list
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


def asset_update(request):
    pass




#Auxiliar functions ↓