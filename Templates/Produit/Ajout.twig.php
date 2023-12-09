{% extends "layout.php" %}

{% block title %}
    Ajouter un Produit
{% endblock %}

{% block content %}
{% if session.admin is defined %}
    <h1 class="fw-light">Ajouter un Produit</h1>
    <p class="lead text-muted">Formulaire pour ajouter un produit.</p>

    <form method="post" action="/Produit/ajouterProduit">
        <label for="cat_name">Catégorie:</label>
        <input type="text" id="cat_name" name="cat_name" required>
        <br>

        <label for="name">Nom:</label>
        <input type="text" id="name" name="name" required>
        <br>

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required></input>
        <br>

        <label for="image">Image:</label>
        <input type="text" id="image" name="image" required>
        <br>

        <label for="price">Prix:</label>
        <input type="text" id="price" name="price" required>
        <br>

        <input type="submit" value="Ajouter">
    </form>
    {% else %}
        Vous n'avez pas l'autorisation d'acceder a cette page
    {% endif %}
{% endblock %}
