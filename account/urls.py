from django.urls import path, include
from . import views

app_name = 'accounts'

urlpatterns = [    
    path('', views.account_index, name='index'),
    path('/create/', views.account_create, name='create'),
    path('/update/', views.account_update, name='update'),
    path('/delete/', views.account_delete, name='delete'),
]
