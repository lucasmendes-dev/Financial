from django.db import models
from django.contrib.auth import get_user_model


class Category(models.Model):
    category_name = models.CharField(max_length=100)
    
    def __str__(self):
        return self.category_name


class AccountType(models.Model):
    type_name = models.CharField(max_length=100)
    
    def __str__(self):
        return self.type_name
    

class Account(models.Model):
    account_type = models.ForeignKey(AccountType, on_delete=models.CASCADE)
    account_name = models.CharField(max_length=100)
    account_balance = models.FloatField(default=0.0)
    user = models.ForeignKey(get_user_model(), on_delete=models.CASCADE)
    
    def __str__(self):
        return self.account_name


class AccountStatement(models.Model):
    statement_name = models.CharField(max_length=100)
    statement_type = models.CharField(max_length=20)
    statement_value = models.FloatField(default=0.0)
    statement_date = models.DateTimeField()
    account = models.ForeignKey(Account, on_delete=models.CASCADE)
    category = models.ForeignKey(Category, on_delete=models.CASCADE)
    
    def __str__(self):
        return self.statement_name
    
    
