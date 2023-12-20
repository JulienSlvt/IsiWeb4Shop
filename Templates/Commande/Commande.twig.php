{% extends "layout.php" %}

{% block title %}
    Commande
{% endblock %} 


{% block content %}
    {% if commande is defined %}
        {% block sourcestyle %}
            <link href="../../assets/dist/css/bootstrap.min.css" rel="stylesheet">
        {% endblock %}

        {% block sourcescript %}
                <script src="../../assets/dist/js/bootstrap.bundle.min.js"></script>
        {% endblock %}
        <div class="container mt-4">
            <h2>Votre Commande</h2>
                <div class="card mb-3">
                    <div class="card-header">
                        Commande #{{ commande.id }}
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ commande.id }}</td>
                                </tr>
                                <tr>
                                    <th>Customer ID</th>
                                    <td>{{ commande.customer_id }}</td>
                                </tr>
                                <tr>
                                    <th>Registered</th>
                                    <td>{{ commande.registered }}</td>
                                </tr>
                                <tr>
                                    <th>Delivery Address ID</th>
                                    <td>{{ commande.delivery_add_id }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Type</th>
                                    <td>{{ commande.payment_type }}</td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td>{{ commande.date }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ commande.status }}</td>
                                </tr>
                                <tr>
                                    <th>Session</th>
                                    <td>{{ commande.session }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>{{ commande.total }} €</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    {% else %}
        {% if encrypted is defined %}
            <div class="container mt-4">
                <p>Votre numéro de Suivi : {{ encrypted }}</p>
            </div>
        {% else %}
            <form method="post" action="/Commande/Acceder">
                <div class="mb-3">
                    <label for="order_id" class="form-label">Numéro de commande:</label>
                    <input type="text" class="form-control" id="order_id" name="order_id" required>
                    <div class="invalid-feedback">
                        Veuillez entrer votre numéro de commande
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </form>
        {% endif %} 
    {% endif %}
{% endblock %}

