from django import forms
from .models import Statement


class StatementForm(forms.ModelForm):
    
    class Meta:
        model = Statement
        fields = ('statement_description', 'statement_value', 'statement_date', 'account', 'statement_category', 'statement_type')
        
        widgets = {
            'statement_description': forms.TextInput(attrs={'class': 'form-control col-md-6'}),     
            'statement_value': forms.NumberInput(attrs={'class': 'form-control col-md-12'}),             
            'statement_date': forms.TextInput(attrs={'class': 'form-control col-md-6'}),    
            'account': forms.Select(attrs={'class': 'form-control col-md-4'}),    
            'statement_category': forms.Select(attrs={'class': 'form-control col-md-4'}),    
            'statement_type': forms.Select(attrs={'class': 'form-control col-md-4'}),                                    
        }
