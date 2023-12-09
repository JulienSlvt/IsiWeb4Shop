{% extends "layout.php" %}

{% block title %}
    Produits
{% endblock %} 

{% block content %}
    <h1 class="fw-light">Bienvenue sur la page des produits</h1>
    <p class="lead text-muted">C'est du contenu de la page des produits.</p>
{% endblock %}

{% block sourcestyle %}
        <link href="../../assets/dist/css/bootstrap.min.css" rel="stylesheet">
{% endblock %}

{% block sourcescript %}
        <script src="../../assets/dist/js/bootstrap.bundle.min.js"></script>
{% endblock %}

{% block produit %}
    {% if produits %}   
        <div class="album py-5 bg-light">
            <div class="container">
                <h2>{{ categorie }}</h2>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-4 g-3">
                    {% for produit in produits %}
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
                                            <label for="quantity-{{ produit.id }}" class="visually-hidden">Quantité</label>
                                            <input type="number" id="quantity-{{ produit.id }}" class="form-control form-control-lg" value="1" min="1">
                                            <button type="button" class="btn btn-sm btn-primary">Ajouter au panier</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {% endfor %}
                </div>
            </div>
        </div>
    {% else %}
        <p>Aucun produit disponible.</p>
    {% endif %}
{% endblock %}
