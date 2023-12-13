{% extends "layout.php" %}

{% block title %}
    Panier
{% endblock %} 

{% block content %}
    <h1 class="fw-light">Bienvenue sur la page des produits</h1>
    <p class="lead text-muted">C'est du contenu de la page des produits.</p>
    {# Barre de choix des catégories #}
    <form action="/Produit/Categorie" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="cat_name" class="form-label">Choisissez une catégorie :</label>
            <select id="cat_name" name="cat_name" class="form-select">
                <option value="" selected disabled>Choisissez une catégorie</option>
                {% for category in categories %}
                    <option value="{{ category }}">{{ category }}</option>
                {% endfor %}
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Aller à la catégorie</button>
    </form>
{% endblock %}

{% block produit %}
    {% if produits %}   
        {% for categorie, listeProduits in produits %}
            <div class="album py-5 bg-light">
                <div class="container">
                    <h2>{{ categorie }}</h2>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-4 g-3">
                        {% for produit in listeProduits %}
                            <div class="col">
                                <div class="card shadow-sm">
                                    {# Utilisez un lien autour de l'image ou du nom pour rediriger l'utilisateur #}
                                    <a href="/Produit/Details/{{ produit.id }}">
                                        <img src="../../static/Images/{{ produit.image }}" alt="{{ produit.name }}" class="img-fluid reset-image-style">
                                    </a>
                                    <div class="card-body">
                                        <p class="card-text">
                                            <a href="/Produit/Details/{{ produit.id }}" class="text-decoration-none link-dark fs-5 fw-bold" style="transition: font-size 0.3s, color 0.3s;">
                                                {{ produit.name }}<br>
                                            </a>
                                            {{ produit.description }}<br>
                                            <small class="text-muted">Prix: {{ produit.price }} €</small>
                                        </p>
                                    </div>
                                
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div class="input-group">
                                            <form action="/Panier/AjoutPanier" method="post" class="row g-2">
                                                <div class="col-md-6">
                                                    <label for="quantite" class="visually-hidden">Quantité</label>
                                                    <input type="number" id="quantite" name="quantite" class="form-control form-control-lg" value="1" min="1" max="500">
                                                </div>
                                                <input type="hidden" name="produit" value="{{ produit.id }}">
                                                <div class="col-md-6">
                                                    <button type="submit" class="btn btn-sm btn-primary">Ajouter au panier</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {% endfor %}
                    </div>
                </div>
            </div>
        {% endfor %}
    {% else %}
        <p>Aucun produit disponible.</p>
    {% endif %}
{% endblock %}
