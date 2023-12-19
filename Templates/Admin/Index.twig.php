{% extends "layout.php" %}

{% block title %}
    Admin
{% endblock %} 

{% block content %}
    <a href="/Admin/AjoutProduit" class="btn btn-sm btn-success">Ajouter un produit</a>
    <a href="/Admin/GererCommandes" class="btn btn-sm btn-info">Gérer les commandes</a>
{% endblock %}
