from django.urls import path, include
from . import views

app_name = 'homepage'

urlpatterns = [    
    path('', views.homepage, name='home'),
]
