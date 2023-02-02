from django.urls import path, include
from . import views

app_name = 'statements'

urlpatterns = [    
    path('', views.statement_index, name='index'),
    path('create/', views.statement_create, name='create'),
    path('update/<int:id>', views.statement_update, name='update'),
    path('delete/<int:id>', views.statement_delete, name='delete'),
]
