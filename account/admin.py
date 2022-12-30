from django.contrib import admin
from .models import Category, Account, AccountStatement, AccountType


# Register your models here.
admin.site.register(Category)
admin.site.register(Account)
admin.site.register(AccountStatement)
admin.site.register(AccountType)