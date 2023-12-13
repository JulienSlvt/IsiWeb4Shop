{% extends "layout.php" %}

{% block title %}
    Panier
{% endblock %} 

{% block contentexiste %}{% endblock %}

{% block produit %}
    {% if itemsInCart %}
    <div class="album py-5 bg-light">
        <div class="container">
            <h1 class="fw-light">Votre Panier</h1>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 row-cols-lg-4 g-3">
            {% for item in itemsInCart %}
                <div class="col">
                    <div class="card shadow-sm">
                        <a href="/Produit/Details/{{ item.id }}">
                            <img src="../../static/Images/{{ item.image }}" alt="{{ item.name }}" class="img-fluid reset-image-style">
                        </a>
                        <div class="card-body">
                            <p class="card-text">
                                <a href="/Produit/Details/{{ item.id }}" class="text-decoration-none link-dark fs-5 fw-bold" style="transition: font-size 0.3s, color 0.3s;">
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
                    <button type="button" class="btn btn-primary">Passer la commande</button>
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
