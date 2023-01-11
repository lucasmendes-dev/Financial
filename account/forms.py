from django import forms
from .models import Account


class AccountForm(forms.ModelForm):
    
    class Meta:
        model = Account
        fields = ('account_type', 'account_name', 'account_balance')
        
        widgets = {
            'account_type': forms.Select(attrs={'class': 'form-control col-md-6'}),     
            'account_name': forms.TextInput(attrs={'class': 'form-control col-md-6'}),             
            'account_balance': forms.NumberInput(attrs={'class': 'form-control col-md-6'}),                     
        }