{% extends "layout.php" %}

{% block title %}
    Panier
{% endblock %} 

{% block contentexiste %}{% endblock %}

{% block sourcestyle %}
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/font-awesome/all.min.css">
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
                            <form action="/Panier/deleteProduitDuPanier" method="post" style="position: absolute; top: 0; left: 0;">
                                <input type="hidden" name="produit" value="{{ item.id }}">
                                <button type="submit" class="btn btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer du panier">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                        <path d="M.644 0L0 .644 7.356 8 0 15.356l.644.644L8 8.644 15.356 16l.644-.644L8.644 8 16 .644 15.356 0 8 7.356.644 0z"/>
                                    </svg>
                                </button>
                            </form>
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
                                <small class="text-muted">Prix : {{ item.quantity * item.price }} €</small>
                            </p>
                        </div>
                    
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div class="input-group">
                                <form action="/Panier/ModifierQuantite" method="post" class="row g-2">
                                    <div class="col-md-6">
                                        <label for="quantite" class="visually-hidden">Quantité</label>
                                        <input type="number" id="quantite" name="quantite" class="form-control form-control-lg" value="{{ item.quantity }}" min="0" max="500">
                                    </div>
                                    <input type="hidden" name="produit" value="{{ item.id }}">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-sm btn-primary">Modifier la quantité</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            {% endfor %}
        </div>
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    <p>Total du panier : {{ totalCartPrice }} €</p>
                    {% if session.user is defined %}
                    <a href="/Commande" class="text-decoration-none">
                        <button type="button" class="btn btn-primary">Passer la commande</button>
                    </a>
                    {% else %}
                        <a href="/Connexion" class="text-decoration-none">
                            <button type="button" class="btn btn-primary">Connectez-vous</button>
                        </a>
                    {% endif %}
                
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
