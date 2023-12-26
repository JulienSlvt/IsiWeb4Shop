{% extends "layout.php" %}

{% block title %}
    VoirPanier
{% endblock %} 

{% block contentexiste %}{% endblock %}

{% block sourcestyle %}
        <link href="../../assets/dist/css/bootstrap.min.css" rel="stylesheet">
{% endblock %}

{% block sourcescript %}
        <script src="../../assets/dist/js/bootstrap.bundle.min.js"></script>
{% endblock %}

{% block produit %}
    {% if itemsInCart %}
    <div class="album py-5 bg-light">
        <div class="container">
            <h1 class="fw-light">Votre Panier</h1>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-4 g-3">
            {% for item in itemsInCart %}
                <div class="col">
                    <div class="card shadow-sm">
                        <div style="position: relative;">
                            <a href="/Produit/Details/{{ item.id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ item.name }}">
                                <img src="../../static/Images/{{ item.image }}" alt="{{ item.name }}" class="img-fluid reset-image-style">
                            </a>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <a href="/Produit/Details/{{ item.id }}" class="text-decoration-none link-dark fs-5 fw-bold" style="transition: font-size 0.3s, color 0.3s;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ item.name }}">
                                    {{ item.name }}<br>
                                </a>
                                {{ item.description }}<br>
                                <small class="text-muted">Prix à l'unité : {{ item.price }} €</small><br>
                                <small class="text-muted">Quantité : {{ item.orderquantity }}</small><br>
                                <small class="text-muted">Prix : {{ item.orderquantity * item.price }} €</small>
                            </p>
                        </div>
                    </div>
                </div>
            {% endfor %}
        </div>
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <p>Total du panier : {{ totalCartPrice }} €</p>
                    <a href="/Commande/ModifierAdresse" class="text-decoration-none">
                        <button type="button" class="btn btn-primary">Passer la commande</button>
                    </a>
                </div>
            </div>
        </section>
    {% else %}
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <p>Votre panier est vide.</p>
                </div>
            </div>
        </section>
    {% endif %}
{% endblock %}
