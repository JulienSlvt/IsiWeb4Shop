{% extends "layout.php" %}

{% block title %}
    Admin
{% endblock %} 

{% block content %}
    <a href="/Admin/AjoutProduit" class="btn btn-sm btn-success">Ajouter un produit</a>
    <a href="/Admin/GererCommandes" class="btn btn-sm btn-info">Gérer les commandes</a>
    <a href="/Admin/GererQuantites" class="btn btn-sm btn-success">Gérer les quantités</a>
{% endblock %}
