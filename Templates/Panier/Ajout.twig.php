{% extends "layout.php" %}

{% block title %}
    Ajout de Produit au Panier
{% endblock %} 

{% block content %}
    <h1 class="fw-light">Ajout de Produit au Panier</h1>

    <form method="post" action="/ajout-produit">
        <label for="produit">Produit :</label>
        <select name="produit" id="produit">
            {# Optionnel : Vous pouvez boucler sur les produits disponibles et les afficher dans une liste déroulante #}
            <option value="1">Produit 1</option>
            <option value="2">Produit 2</option>
            {# ... Ajoutez d'autres options selon votre application #}
        </select>

        <br>

        <label for="quantite">Quantité :</label>
        <input type="number" name="quantite" id="quantite" min="1" value="1">

        <br>

        <button type="submit" class="btn btn-primary">Ajouter au Panier</button>
    </form>
{% endblock %}
