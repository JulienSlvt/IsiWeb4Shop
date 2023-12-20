{% extends "layout.php" %}

{% block title %}
    {% if produit %}  
         {{ produit.name }}
    {% else %}
        Produit inexistant
    {% endif %}
{% endblock %} 

{% block content%}
    {% if not produit %}
        <p>Le produit n'existe pas</p>
    {% else %}
        {% block contentexiste %}{% endblock %}
    {% endif %}
{% endblock %}

{% block produit %}
    {% if produit %}  
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6">
                    <img class="card-img-top mb-5 mb-md-0" src="../../../static/Images/{{ produit.image }}" alt="...">
                    </div>
                    <div class="col-md-6">
                    <div class="small mb-1">ID du produit : {{ produit.id }}</div>
                    <h1 class="display-5 fw-bolder">{{ produit.name }}</h1>
                    <div class="fs-5 mb-5">
                        <!-- <span class="text-decoration-line-through">$45.00</span> -->
                        <span>Prix : {{ produit.price }} €</span>
                    </div>
                    Description :<br>
                    <p class="lead">{{ produit.description }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="input-group">
                        {% if produit.quantity > 0 %}
                            <form action="/Panier/AjoutPanier" method="post">
                                {# Ajoutez un champ pour la quantité, remplacez 'produit.id' par votre propre identifiant du produit #}
                                <label for="quantity-{{ produit.id }}" class="visually-hidden">Quantité</label>
                                <input type="number" id="quantity-{{ produit.id }}" name="quantite" class="form-control form-control-lg" value="1" min="1" max="{{ produit.quantity }}">
                                <input type="hidden" name="produit" value="{{ produit.id }}">
                                {# Ajoutez le bouton pour soumettre le formulaire #}
                                <button type="submit" class="btn btn-sm btn-primary">Ajouter au panier</button>
                            </form>
                            {% endif %}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {% endif %}
{% endblock %}

{% block sourcestyle %}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
{% endblock %}

{% block sourcescript %}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
{% endblock %}
