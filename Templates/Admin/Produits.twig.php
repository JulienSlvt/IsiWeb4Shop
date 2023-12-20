{% extends "layout.php" %}

{% block title %}
    Products Management
{% endblock %}

{% block content %}
    <a href="/Admin/AjoutProduit" class="btn btn-sm btn-success">Ajouter un produit</a>
    <a href="/Admin/GererCommandes" class="btn btn-sm btn-info">Gérer les commandes</a>
    <a href="/Admin/GererQuantites" class="btn btn-sm btn-success">Ajouter un produit</a>
{% endblock %}

{% block produit %}
    <h2>Product Management</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Category ID</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Image</th>
                <th scope="col">Price</th>
                <th scope="col">Quantity</th>
            </tr>
        </thead>
        <tbody>
            {% for categorie, listeProduits in produits %}
                {% for product in listeProduits %}
                    <tr>
                        <th scope="row">{{ product.id }}</th>
                        <td>{{ product.cat_id }}</td>
                        <td>{{ product.name }}</td>
                        <td>{{ product.description }}</td>
                        <td>{{ product.image }}</td>
                        <td>{{ product.price }}</td>
                        <td>
                            <form method="post" action="/admin/modifierQuantites">
                                <input type="hidden" name="product_id" value="{{ product.id }}">
                                <input type="number" name="quantity" value="{{ product.quantity }}" min="0">
                                <button type="submit" class="btn btn-sm btn-primary">Update Quantity</button>
                            </form>
                        </td>
                        <td>
                        </td>
                    </tr>
                {% endfor %}
            {% endfor %}
        </tbody>
    </table>
{% endblock %}
