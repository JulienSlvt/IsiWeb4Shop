{% extends "layout.php" %} 
{% block title %}
    Panier
{% endblock %} 

{% block content %}
    <h1 class="fw-light">Bienvenue sur ma page de panier</h1>
    <p class="lead text-muted">C'est du contenu de la page de panier.</p>
    {% block panier %}
    Tous les produits
    
    {% endblock %}
{% endblock %}
