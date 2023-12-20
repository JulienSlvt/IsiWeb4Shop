{% extends "layout.php" %} 
{% block title %}
    Connexion
{% endblock %} 

{% block content %}
    <h1 class="fw-light">Bienvenue sur ma page de connexion</h1>
    <p class="lead text-muted">C'est du contenu de la page de connexion.</p>
    <p class="text-danger">Compte inexistant</p>
    <form method="post" action="/connexion/connexion" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="username" class="form-label">Nom d'utilisateur:</label>
            <input type="text" class="form-control" id="username" name="username" required>
            <div class="invalid-feedback">
                Veuillez fournir un nom d'utilisateur.
            </div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe:</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <div class="invalid-feedback">
                Veuillez fournir un mot de passe.
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
{% endblock %}
