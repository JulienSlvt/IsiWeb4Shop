{% extends "layout.php" %} 
{% block title %}
    Connexion
{% endblock %} 

{% block content %}
    <h1 class="fw-light">Bienvenue sur ma page de connexion</h1>
    <p class="lead text-muted">C'est du contenu de la page de connexion.</p>

    <form method="post" action="/connexion/connexion">
        <p class="text-danger">Compte inexistant</p>
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" value="Se connecter">
    </form>
{% endblock %}
