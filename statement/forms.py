from django import forms
from .models import Statement


class EarningForm(forms.ModelForm):
    
    class Meta:
        model = Statement
