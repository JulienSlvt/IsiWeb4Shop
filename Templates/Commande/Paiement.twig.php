{% extends "layout.php" %}

{% block title %}
    Adresse
{% endblock %}

{% block sourcestyle %}
        <link href="../../assets/dist/css/bootstrap.min.css" rel="stylesheet">
{% endblock %}

{% block sourcescript %}
        <script src="../../assets/dist/js/bootstrap.bundle.min.js"></script>
{% endblock %}

{% block content %}
    {% if session.user is defined %}
        {% if paiements %}
            <form action="/Commande/Payer" method="POST" class="mt-4">
                <div class="mb-3">
                    <p><label class="form-label">Prix à payer : {{ total }} €</label></p>
                    <label for="paiement" class="form-label">Choisissez un moyen de paiement :</label>
                    <select id="paiement" name="paiement" class="form-select">
                        {% for p in paiements %}
                            {% if p == paiementuser %}
                                <option value="{{ p }}" selected>{{ p }}</option>
                            {% else %}
                                <option value="{{ p }}">{{ p }}</option>
                            {% endif %}
                        {% endfor %}
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Valider</button>
            </form>
        {% endif %}
    {% else %}
        {% if paiements %}
            <form action="/Commande/Payer" method="POST" class="mt-4">
                <div class="mb-3">
                    <p><label class="form-label">Prix à payer : {{ total }} €</label></p>
                    <label for="paiement" class="form-label">Choisissez un moyen de paiement :</label>
                    <select id="paiement" name="paiement" class="form-select">
                        {% for p in paiements %}
                            <option value="{{ p }}">{{ p }}</option>
                        {% endfor %}
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Valider</button>
            </form>
        {% endif %}
    {% endif %}
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
                                <small class="text-muted">Quantité : {{ item.quantity }}</small><br>
                                <small class="text-muted">Prix : {{ item.quantity * item.price }} €</small>
                            </p>
                        </div>
                    </div>
                </div>
            {% endfor %}
        </div>
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
