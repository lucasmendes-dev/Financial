from django.urls import path, include
from . import views

app_name = 'earnings'

urlpatterns = [    
    path('', views.earning_index, name='index'),
    path('create/', views.earning_create, name='create'),
    path('update/<int:id>', views.earning_update, name='update'),
    path('delete/<int:id>', views.earning_delete, name='index'),
]
