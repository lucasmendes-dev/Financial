from django.contrib import admin
from .models import Asset, AssetTransaction, Patrimony


# Register your models here.
admin.site.register(Asset)
admin.site.register(AssetTransaction)
admin.site.register(Patrimony)