from django import forms
from .models import Earning


class EarningForm(forms.ModelForm):
    
    class Meta:
        model = Earning
        fields = ('asset_qty', 'earning_value', 'asset', 'earning_date')
        
        widgets = {
            'asset_qty': forms.NumberInput(attrs={'class': 'form-control col-md-6', 'placeholder':"Ex: 15"}),     
            'earning_value': forms.NumberInput(attrs={'class': 'form-control col-md-12', 'placeholder':"Ex: R$0,93"}),             
            'asset': forms.Select(attrs={'class': 'form-control col-md-6', 'placeholder':"Ex: PETR4"}),    
            'earning_date': forms.DateInput(attrs={'class': 'form-control col-md-6'})                         
        }