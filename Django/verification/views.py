from django.shortcuts import render,redirect
from django.contrib import messages
from django.contrib.auth.decorators import login_required
# Create your views here.
@login_required(login_url='signin')
def verify(request):
    return render(request, 'verification.html')
@login_required(login_url='signin')
def checked_status(request,status):
    if(status==1):
        messages.success(request,'User Dose 1 verified!')
    elif(status==2):
        messages.success(request,'User Dose 2 verified!')
    elif(status==3):
        messages.warning(request,'Dose 1 already taken!')
    elif(status==4):
        messages.warning(request,'Dose 2 already taken!')
    elif(status==5):
        messages.error(request,'User data mismatched!')
    else:
        messages.error(request,'Given ID number not registered!')
    return redirect('verification')