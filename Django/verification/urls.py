from django.urls import path
from . import views

urlpatterns = [
    path('verification/', views.verify, name='verification'),
    path('checked_status/<int:status>', views.checked_status, name='checked_status'),
]