from django.urls import path, include
from . import views

app_name = 'assets'

urlpatterns = [    
    path('', views.asset_index, name='index'),
    path('create/', views.asset_create, name='create'),    
    path('update/<int:id>', views.asset_update, name='update'),    
]
