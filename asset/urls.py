from django.urls import path, include
from . import views

app_name = 'assets'

urlpatterns = [    
    path('', views.asset_index, name='index'),
    path('create/', views.asset_create, name='create'),
    path('store/', views.asset_store, name='store'),
    path('edit/<int:pk>', views.asset_edit, name='edit'),
    path('update/', views.asset_update, name='update'),
    path('delete/', views.asset_delete, name='delete'),
]
