<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title>{% block title %}Ma page{% endblock %}</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/album/">




    {% block sourcestyle %}
        <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
    {% endblock %}

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }
        
        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
        
        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }
        
        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }
        
        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }
        
        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }
        
        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
        
    </style>
    {% block style %}{% endblock %}
{{ session.temp }}{{ session.id }}
</head>
<body>
    <header>
        <div class="collapse bg-dark" id="navbarHeader">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-7 py-4">
                        <h4 class="text-white">Description</h4>
                        <p class="text-muted">
                            Bienvenue sur ISIWEB4SHOP, la référence en matière de shopping en ligne ! <br>
                            Explorez notre vaste catalogue incluant des vêtements tendance, des gadgets innovants et bien plus encore.
                            Chez ISIWEB4SHOP, la qualité est garantie, avec des produits minutieusement sélectionnés auprès de marques de confiance.
                            Profitez d'une expérience de navigation conviviale, découvrez des offres spéciales et des promotions attractives.
                            Notre site sécurisé assure la confidentialité de vos transactions. Bénéficiez d'une livraison rapide et suivez votre commande en temps réel.
                            ISIWEB4SHOP s'engage à rendre votre expérience d'achat en ligne simple, sécurisée et agréable.
                        </p>
                    </div>
                    <div class="col-sm-4 offset-md-1 py-4">
                        <h4 class="text-white">Produits</h4>
                        <ul class="list-unstyled">
                            <li><a href="/Produit/Boissons" class="text-white">Boissons</a></li>
                            <li><a href="/Produit/Biscuits" class="text-white">Biscuits</a></li>
                            <li><a href="/Produit/FruitsSecs" class="text-white">Fruits secs</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a href="/" class="navbar-brand d-flex align-items-center">
                    <strong>ISIWEB4SHOP</strong>
                </a>
                <a href="/Panier" class="navbar-brand d-flex align-items-center">
                    Panier
                </a>
                <a href="/Produit" class="navbar-brand d-flex align-items-center">
                    Produits
                </a>
                {% if session.admin is defined %}
                <a href="/Produit/Ajout" class="navbar-brand d-flex align-items-center">
                        Ajouter un Produit
                    </a>
                {% endif %}
                {% if session.user is defined %}
                    <a href="/Panier" class="navbar-brand d-flex align-items-center">
                        Bienvenue, {{ session.user }} !
                    </a>
                    <a href="/Connexion/Deconnexion" class="navbar-brand d-flex align-items-center">
                        Deconnexion
                    </a>
                {% else %}
                    <a href="/Connexion" class="navbar-brand d-flex align-items-center">
                        Connexion
                    </a>
                    <a href="/Inscription" class="navbar-brand d-flex align-items-center">
                        Inscription
                    </a>
                {% endif %}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
            </div>
        </div>
    </header>

    <main>
        <section class="py-5 text-center container">
            <div class="row py-lg-5">
                <div class="col-lg-6 col-md-8 mx-auto">
                    {% block content%}{% endblock %}
                    </p>
                </div>
            </div>
        </section>
        {% block produit %}{% endblock %}
    </main>

    <footer class="bg-white text-center rounded-0 py-3">
        {% block footer %} &copy; {{ "now"|date("Y") }} -
        <a href="https://polytech.univ-lyon1.fr/">Polytech Info 3A</a>. {% endblock %}
    </footer>
    {% block sourcescript %}
        <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    {% endblock %}

</body>

</html>