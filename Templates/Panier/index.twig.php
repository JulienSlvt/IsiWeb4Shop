{% extends "layout.php" %}

{% block title %}
    Panier
{% endblock %} 

{% block content %}
    <h1 class="fw-light">Votre Panier</h1>

    {% if itemsInCart %}
        <table class="table">
            <thead>
                <tr>    
                    <th scope="col">Produit</th>
                    <th scope="col">Quantité</th>
                    <th scope="col">Prix unitaire</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                {% for item in itemsInCart %}
                    <tr>
                        <td>{{ item.name }}</td>
                        <td>{{ item.quantity }}</td>
                        <td>{{ item.price }} €</td>
                        <td>{{ item.quantity * item.price }} €</td>
                    </tr>
                {% endfor %}
            </tbody>
        </table>
        <p>Total du panier : {{ totalCartPrice }} €</p>
        <button type="button" class="btn btn-primary">Passer la commande</button>
    {% else %}
        <p>Votre panier est vide.</p>
    {% endif %}
{% endblock %}
