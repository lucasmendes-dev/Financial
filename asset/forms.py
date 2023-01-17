from django import forms
from .models import Asset, AssetTransaction


class AssetForm(forms.ModelForm):
    
    class Meta:
        model = Asset
        fields = ('asset_type', 'asset_name', 'asset_code', 'asset_qty', 'average_price', 'status')
        
        widgets = {
            'asset_type': forms.Select(attrs={'class': 'form-control col-md-6'}),     
            'asset_name': forms.TextInput(attrs={'class': 'form-control col-md-12', 'placeholder':"Ex: Petrobras"}),             
            'asset_code': forms.TextInput(attrs={'class': 'form-control col-md-6', 'placeholder':"Ex: PETR4"}),    
            'asset_qty': forms.NumberInput(attrs={'class': 'form-control col-md-4'}),    
            'average_price': forms.NumberInput(attrs={'class': 'form-control col-md-4'}),    
            'status': forms.Select(attrs={'class': 'form-control col-md-4'}),                                    
        }