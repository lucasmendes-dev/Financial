from django.urls import path, include
from . import views

app_name = 'statements'

urlpatterns = [    
    path('', views.statement_index, name='index'),
]
