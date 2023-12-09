<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Joueurs</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        td {
            border: 1px solid black;
            padding: 10px;
            width: 20%; /* Ajustez la largeur de la cellule en fonction du nombre de colonnes souhaité */
        }
    </style>
</head>
<body>

    <h1>Liste des Joueurs</h1>

    <nav>
    <form id="rechercheForm">
        <input type="text" id="rechercheInput" placeholder="Rechercher..." oninput="filtrerCaracteres(this)" onkeydown="detecterTouche(event)">
        <button type="button" onclick="rechercher()">Rechercher</button>

        <!-- <a href="http://projetperso.local/index.php/PageTest"><button type="button">PageTest</button></a>  J'aime pas comment c'est fait -->
    </form>
</nav>

    <table>
        <tr>
            <?php $count = 0; ?>
            <?php foreach ($joueurs as $joueur): ?>
                <td>
                    <?php echo "Nom: {$joueur['nom']}<br>"; ?>
                    <?php echo "Prénom: {$joueur['prenom']}<br>"; ?>
                    <?php echo "Âge: {$joueur['age']}<br>"; ?>
                    <?php echo "Équipe: {$joueur['equipe']}<br>"; ?>
                    <?php echo "Poste: {$joueur['poste']}<br>"; ?>
                </td>
                <?php $count++; ?>
                <?php if ($count % 4 === 0): ?> <!-- Changez 4 en fonction du nombre de colonnes souhaité -->
                    </tr><tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>
    </table>
    <script>
        function filtrerCaracteres(input) {
                // Remplace tous les caractères qui ne sont pas des lettres par une chaîne vide
                input.value = input.value.replace(/[^a-zA-Z]/g, '');
            }

        function detecterTouche(event) {
            if (event.key === "Enter") {
                event.preventDefault(); // Empêche la soumission du formulaire
                // Vous pouvez ajouter d'autres actions ici si nécessaire
                rechercher();
            }
        }
        function rechercher() {
            var rechercheInput = document.getElementById('rechercheInput').value;
            if (rechercheInput.trim() !== '') {
                window.location.href = '/PageTest/test3/' + encodeURIComponent(rechercheInput);
                
            }
        }
    </script>
</body>

</html>
