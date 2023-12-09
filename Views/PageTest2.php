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

</body>
</html>
