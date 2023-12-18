{% extends "layout.php" %}

{% block title %}
    Commandes
{% endblock %} 

{% block content %}
    <h1 class="fw-light">Mes commandes</h1>
    {% if not commandes %}  
        <br>
        <p>Vous n'avez fait aucune commande</p>
    {% endif %}
{% endblock %}

{% block produit %}
    <div class="container mt-4">
        <h2>Liste des Commandes</h2>
        {% if commandes %}
            {% for order in commandes %}
                <div class="card mb-3">
                    <div class="card-header">
                        Commande #{{ order.id }}
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ order.id }}</td>
                                </tr>
                                <tr>
                                    <th>Customer ID</th>
                                    <td>{{ order.customer_id }}</td>
                                </tr>
                                <tr>
                                    <th>Registered</th>
                                    <td>{{ order.registered }}</td>
                                </tr>
                                <tr>
                                    <th>Delivery Address ID</th>
                                    <td>{{ order.delivery_add_id }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Type</th>
                                    <td>{{ order.payment_type }}</td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td>{{ order.date }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ order.status }}</td>
                                </tr>
                                <tr>
                                    <th>Session</th>
                                    <td>{{ order.session }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>{{ order.total }} €</td>
                                </tr>
                                <!-- Ajoutez d'autres détails de commande ici -->
                                <!-- ... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            {% endfor %}
        {% endif %}
    </div>
{% endblock %}

