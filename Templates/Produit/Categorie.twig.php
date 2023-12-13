{% extends "layout.php" %}

{% block title %}
    Produits
{% endblock %} 

{% block content %}
    {% if produits %}  
    <h1 class="fw-light">Bienvenue sur la page de la catégorie {{ categorie }}</h1>
    <form action="/Produit/Categorie" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="cat_name" class="form-label">Choisissez une catégorie :</label>
            <select id="cat_name" name="cat_name" class="form-select">
                {% for category in categories %}
                    {% if category == categorie %}
                        <option value="{{ category }}" selected>{{ category }}</option>
                    {% else %}
                        <option value="{{ category }}">{{ category }}</option>
                    {% endif %}
                {% endfor %}
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Aller à la catégorie</button>
    </form>

    {% endif %}
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
                                <a href="/Produit/Details/{{ produit.id }}">
                                    <img src="../../static/Images/{{ produit.image }}" alt="{{ produit.name }}" class="img-fluid reset-image-style">
                                </a>
                                <div class="card-body">
                                    <p class="card-text">
                                        <a href="/Produit/Details/{{ produit.id }}" class="text-decoration-none link-dark fs-5 fw-bold" style="transition: font-size 0.3s, color 0.3s;">
                                            <strong>{{ produit.name }}</strong><br>
                                        </a>
                                        {{ produit.description }}<br>
                                        <small class="text-muted">Prix: {{ produit.price }} €</small>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                    <div class="input-group">
                                                <form action="/Panier/AjoutPanier" method="post">
                                                    {# Ajoutez un champ pour la quantité, remplacez 'produit.id' par votre propre identifiant du produit #}
                                                    <label for="quantity-{{ produit.id }}" class="visually-hidden">Quantité</label>
                                                    <input type="number" id="quantity-{{ produit.id }}" name="quantite" class="form-control form-control-lg" value="1" min="1" max="500">
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
            </div>
        </div>
    {% else %}
        <p>Aucun produit disponible.</p>
    {% endif %}
{% endblock %}

{% block script %}
    {% if app.request.method == 'POST' %}
        {# Traitement du formulaire (AjoutPanier) #}

        {# Redirection vers la même page après le traitement #}
        <script>
            window.location.href = '/Produit/Accueil';
        </script>
    {% endif %}
{% endblock %}