from django.contrib import admin
from .models import Asset, AssetTransaction, Patrimony, AssetType


# Register your models here.
admin.site.register(Asset)
admin.site.register(AssetTransaction)
admin.site.register(Patrimony)
admin.site.register(AssetType)