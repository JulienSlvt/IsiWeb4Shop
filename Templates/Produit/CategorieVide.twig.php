{% extends "layout.php" %}

{% block title %}
    Produits
{% endblock %} 

{% block content %}
    <h1 class="fw-light">Bienvenue sur la page des produits</h1>
    {# Barre de choix des catégories #}
    <form action="/Produit/Categorie" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="cat_name" class="form-label">Choisissez une catégorie :</label>
            <select id="cat_name" name="cat_name" class="form-select">
                <option value="" selected disabled>Choisissez une catégorie</option>
                {% for category in categories %}
                    <option value="{{ category }}">{{ category|capitalize }}</option>
                {% endfor %}
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Aller à la catégorie</button>
    </form>
{% endblock %}
