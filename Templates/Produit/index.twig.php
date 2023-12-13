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
        <div class="album py-5 bg-light">
            <div class="container">
                {% for categorie, listeProduits in produits %}
                    <h2>{{ categorie }}</h2>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-4 g-3">
                        {% for produit in listeProduits %}
                            <div class="col">
                                <div class="card shadow-sm">
                                    <img src="{{ produit.image }}" alt="{{ produit.name }}" class="img-fluid reset-image-style">
                                    <div class="card-body">
                                        <p class="card-text">
                                            <strong>{{ produit.name }}</strong><br>
                                            {{ produit.description }}<br>
                                            <small class="text-muted">Prix: {{ produit.price }} €</small>
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="input-group">
                                                <form action="/Panier/AjoutPanier" method="post">
                                                    {# Ajoutez un champ pour la quantité, remplacez 'produit.id' par votre propre identifiant du produit #}
                                                    <label for="quantity-{{ produit.id }}" class="visually-hidden">Quantité</label>
                                                    <input type="number" id="quantity-{{ produit.id }}" name="quantite" class="form-control form-control-lg" value="1" min="1">
                                                    
                                                    {# Ajoutez un champ pour l'identifiant du produit, remplacez 'produit.id' par votre propre identifiant du produit #}
                                                    <input type="hidden" name="produit" value="{{ produit.id }}">

                                                    {# Ajoutez le bouton pour soumettre le formulaire #}
                                                    <button type="submit" class="btn btn-sm btn-primary">Ajouter au panier</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {% endfor %}
                    </div>
                {% endfor %}
            </div>
        </div>
    {% else %}
        <p>Aucun produit disponible.</p>
    {% endif %}
{% endblock %}

