from django.db import models
from django.contrib.auth import get_user_model


class StatementType(models.Model):
    statement_type = models.CharField(max_length=100)
    
    def __str__(self):
        return self.statement_type
    
    
class StatementCategory(models.Model):    
    statement_category = models.CharField(max_length=100)
    
    def __str__(self):
        return self.statement_category
    

class Statement(models.Model):
    
    statement_type = models.ForeignKey(StatementType, on_delete=models.CASCADE)
    statement_category = models.ForeignKey(StatementCategory, on_delete=models.CASCADE, null=True)
    statement_description = models.CharField(max_length=100)
    statement_value = models.FloatField(default=0.0)
    statement_date = models.DateTimeField()
    account = models.ForeignKey('account.Account', on_delete=models.CASCADE)
    destiny_account = models.IntegerField(null=True)
    user = models.ForeignKey(get_user_model() , on_delete=models.CASCADE)        

    def __str__(self):
        return self.statement_description