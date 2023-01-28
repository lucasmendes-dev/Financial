from django.urls import path, include
from . import views

app_name = 'earnings'

urlpatterns = [    
    path('', views.earning_index, name='index'),
]
