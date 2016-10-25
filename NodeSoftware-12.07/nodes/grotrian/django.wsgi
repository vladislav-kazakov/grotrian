import os
import sys

# EDIT THE FOLLOWING TWO LINES
sys.path.append('/var/www/NodeSoftware-12.07/')
os.environ['DJANGO_SETTINGS_MODULE'] = 'nodes.grotrian.settings'


import django.core.handlers.wsgi
application = django.core.handlers.wsgi.WSGIHandler()
