# Generated by Django 4.1.3 on 2023-02-02 22:20

from django.db import migrations


class Migration(migrations.Migration):

    dependencies = [
        ('statement', '0002_alter_statement_fowarded'),
    ]

    operations = [
        migrations.RemoveField(
            model_name='statement',
            name='fowarded',
        ),
    ]
