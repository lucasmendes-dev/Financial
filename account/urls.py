from django.urls import path, include
from . import views

app_name = 'accounts'

urlpatterns = [    
    path('', views.account_index, name='index'),
    path('create/', views.account_create, name='create'),
    path('update/<int:id>', views.account_update, name='update'),
    path('delete/<int:id>', views.account_delete, name='delete'),
]
