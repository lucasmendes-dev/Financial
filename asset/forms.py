from django import forms
from .models import Asset, AssetTransaction


class AssetForm(forms.ModelForm):
    
    class Meta:
        model = Asset
        fields = ('asset_type', 'asset_name', 'asset_code', 'asset_qty', 'average_price', 'status')
        
        widgets = {
            'asset_type': forms.TextInput(attrs={'class': 'form-control'}),     
            'asset_name': forms.TextInput(attrs={'class': 'form-control'}),             
            'asset_code': forms.TextInput(attrs={'class': 'form-control'}),    
            'asset_qty': forms.NumberInput(attrs={'class': 'form-control'}),    
            'average_price': forms.NumberInput(attrs={'class': 'form-control'}),    
            'status': forms.NumberInput(attrs={'class': 'form-control'}),                                    
        }