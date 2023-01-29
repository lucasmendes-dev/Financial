from django.shortcuts import render
from django.contrib.auth.decorators import login_required


@login_required
def earning_index(request):
    return render(request, 'earning.html')


def earning_create(request):
    pass


def earning_update(request):
    pass


def earning_delete(request):
    pass


