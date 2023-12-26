{% extends "layout.php" %}

{% block title %}
    Commandes
{% endblock %} 

{% block content %}
    <a href="/Admin/AjoutProduit" class="btn btn-sm btn-success">Ajouter un produit</a>
    <a href="/Admin/GererCommandes" class="btn btn-sm btn-info">Gérer les commandes</a>
    <a href="/Admin/GererQuantites" class="btn btn-sm btn-success">Gérer les quantités</a>
{% endblock %}

{% block produit %}
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Customer ID</th>
                <th scope="col">Registered</th>
                <th scope="col">Delivery Address ID</th>
                <th scope="col">Payment Type</th>
                <th scope="col">Date</th>
                <th scope="col">Status</th>
                <th scope="col">Session</th>
                <th scope="col">Total</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            {% for order in orders|reverse %}
                <tr>
                    <th scope="row"><a href="/Admin/VoirPanier/{{ order.id }}">{{ order.id }}</a></th>
                    <td>{{ order.customer_id }}</td>
                    <td>{{ order.registered }}</td>
                    <td>{{ order.delivery_add_id }}</td>
                    <td>{{ order.payment_type }}</td>
                    <td>{{ order.date|date('Y-m-d') }}</td>
                    <td>{{ order.status }}</td>
                    <td>{{ order.session }}</td>
                    <td>{{ order.total }}</td>
                    <td>
                        {% if order.status != 10 %}
                        <form method="post" action="/admin/validerCommande">
                            <input type="hidden" name="order_id" value="{{ order.id }}">
                            <button type="submit" class="btn btn-sm btn-success">Valider</button>
                        </form>
                        {% endif %}
                        <form method="post" action="/admin/supprimerCommande">
                            <input type="hidden" name="order_id" value="{{ order.id }}">
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            {% endfor %}
        </tbody>
    </table>

{% endblock %}
