<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste Article</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-1/2">
        <h1 class="text-2xl font-bold mb-4 text-center">Liste Article</h1>
        <div class="mb-4">
            <div class="flex items-center mb-2">
            <label class="block font-medium">Client : <?php echo htmlspecialchars($client->getNom() . ' ' . $client->getPrenom()); ?></label>
            </div>
            <div class="flex items-center mb-4">
            <label class="block font-medium">Client : <?php echo htmlspecialchars($client->getTel() ); ?></label>
            </div>
        </div>
        <table class="table-auto w-full border-collapse border border-gray-400">
            <thead>
         
                <tr>
                    <th class="border border-gray-400 px-4 py-2">Article</th>
                    <th class="border border-gray-400 px-4 py-2">Prix</th>
                    <th class="border border-gray-400 px-4 py-2">Qte</th>
                </tr>
            </thead>
            <tbody>


            <?php foreach ($arts as $articles):?>
              

                <tr>
                    <td class="border border-gray-400 px-4 py-2"><?php echo htmlspecialchars( $articles['libelle']) ?? '';?></td>
                    <td class="border border-gray-400 px-4 py-2"><?php echo htmlspecialchars($articles['prix']);?></td>
                    <td class="border border-gray-400 px-4 py-2"><?php echo htmlspecialchars($articles['qte']);?></td>
                </tr>

                <?php endforeach; ?>
                
            </tbody>
        </table>
    </div>
</body>
</html>
