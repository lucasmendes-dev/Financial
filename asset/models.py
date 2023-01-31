from django.db import models
from django.contrib.auth import get_user_model


class AssetType(models.Model):
    
    asset_type = models.CharField(max_length=20)
    
    def __str__(self):
        return self.asset_type


class Asset(models.Model):
    
    asset_type = models.ForeignKey(AssetType, on_delete= models.CASCADE)
    asset_name = models.CharField(max_length=100)
    asset_code = models.CharField(max_length=20)
    asset_qty = models.IntegerField(default=0)
    average_price = models.FloatField(default=0.0)
    status = models.BooleanField()
    user = models.ForeignKey(get_user_model() , on_delete=models.CASCADE)
    account = models.ForeignKey('account.Account', on_delete=models.CASCADE)
        
    def __str__(self):
        return self.asset_code
    

class AssetTransaction(models.Model):
    
    transaction_type = models.CharField(max_length=20)
    asset = models.ForeignKey(Asset, on_delete=models.CASCADE)
    asset_qty = models.IntegerField(default=0)
    asset_average_price = models.FloatField(default=0.0)
    transaction_date = models.DateTimeField()
    
    def __str__(self) -> str:
        return self.asset


class Patrimony(models.Model):
    
    patrimony_balance = models.FloatField(default=0.0)
    patrimony_date = models.DateTimeField()
    user = models.ForeignKey(get_user_model(), on_delete=models.CASCADE)