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
        {% if compte %}
            <div class="container">
                <h1 class="fw-light mt-5">Adresse de livraison</h1>

                <form method="post" action="/Commande/ModifierCompte" class="mt-4">
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="firstname" class="form-label">Prénom:</label>
                            <input type="text" id="firstname" name="firstname" class="form-control" value="{{ compte.forname }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="lastname" class="form-label">Nom:</label>
                            <input type="text" id="lastname" name="lastname" class="form-control" value="{{ compte.surname }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="add1" class="form-label">Adresse 1:</label>
                        <input type="text" id="add1" name="add1" class="form-control" value="{{ compte.add1 }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="add2" class="form-label">Adresse 2:</label>
                        <input type="text" id="add2" name="add2" class="form-control" value="{{ compte.add2 }}">
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="city" class="form-label">Ville:</label>
                            <input type="text" id="city" name="city" class="form-control" value="{{ compte.add3 }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="postcode" class="form-label">Code postal:</label>
                            <input type="text" id="postcode" name="postcode" class="form-control" value="{{ compte.postcode }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Téléphone:</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{ compte.phone }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ compte.email }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Commander avec cette adresse</button>
                </form>
            </div>
        {% endif %}
    {% else %}
        <div class="container mt-5">
            <p class="lead text-danger">Vous n'avez pas l'autorisation d'accéder à cette page.</p>
        </div>
    {% endif %}
{% endblock %}
