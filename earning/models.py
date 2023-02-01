from django.db import models
from django.contrib.auth import get_user_model


class Earning(models.Model):
    
    user = models.ForeignKey(get_user_model() , on_delete=models.CASCADE)
    asset = models.ForeignKey('asset.Asset', on_delete=models.CASCADE)
    asset_qty = models.IntegerField(default=0)
    earning_value = models.FloatField(default=0.0)
    total_value = models.FloatField(default=0.0)
    earning_date = models.DateTimeField()
    

    def __str__(self):
        return self.asset