from django.contrib import admin
from .models import Statement, StatementCategory, StatementType


# Register your models here.
admin.site.register(Statement)
admin.site.register(StatementCategory)
admin.site.register(StatementType)
