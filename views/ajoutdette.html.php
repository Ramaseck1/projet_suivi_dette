<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer Nouvelle Dette</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class=" flex items-center justify-center h-screen">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
    <?php if (isset($_SESSION['message'])): ?>
        <p><?php echo $_SESSION['message']; ?></p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Enregistrer Nouvelle Dette</h2>
            <button class="text-red-500 text-xl">&times;</button>
            
        </div>
      
        <div class="border p-4 rounded-md mb-4">
            <form action="/client/addsearch" method="POST">
            <div class="mb-4">
                <label for="ref" class="block text-sm font-medium text-gray-700">REF</label>
                <div class="flex items-center mt-1">
                    <input type="text" id="ref" name="ref" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-100">
                    <button class="ml-2 bg-blue-500 text-white px-2 py-1 rounded">OK</button>
                </div>
            </form>



            </div>
            <form action="/client/addproduitTotable" method="post">
        

        <label for="libelle">Libellé :</label><br>
        <input type="text" id="libelle" name="libelle" class=" w-20 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-100" value="<?php echo $_SESSION['article']['libelle'] ?? ''; ?>">

        <label for="prix">Prix :</label><br>
        <input type="text" id="prix" name="prix" class=" w-20 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-100" value="<?php echo $_SESSION['article']['prix'] ?? ''; ?>">

        <label for="qte">Quantité :</label>
        <input type="text" id="qte" name="qte" value="<?php echo $_SESSION['article']['qte'] ?? ''; ?>">

        <input type="hidden" name="dette_id" value="<?php echo $_SESSION['id']; ?>">
        <button type="submit" name="ok">OK</button>
        </form>




            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-gray-700">Article</th>
                            <th class="px-4 py-2 text-gray-700">Prix</th>
                            <th class="px-4 py-2 text-gray-700">Qte</th>
                            <th class="px-4 py-2 text-gray-700">Total</th>
                            <th class="px-4 py-2 text-gray-700">dette</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($articlesDette) && !empty($articlesDette)): ?>
            <?php foreach ($articlesDette as $articleDette): ?>
                <tr>
                    <td><?php echo $articleDette['libelle']; ?></td>
                    <td><?php echo $articleDette['prix']; ?></td>
                    <td><?php echo $articleDette['qte']; ?></td>
                    <td><?php echo $articleDette['montant']; ?></td>
                    <td><?php echo $articleDette['dette_id']; ?></td>

                </tr>
            <?php endforeach; ?>
            <tr>
        <td colspan="4" style="text-align: right;"><strong>Montant total des prix :</strong></td>
        <td><?php echo htmlspecialchars($_SESSION['total_montant'] ?? '0.00'); ?></td>
    </tr>
        <?php endif; ?>
    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-center">
            <button class="bg-blue-500 text-white px-4 py-2 rounded">Enregistrer</button>
        </div>
    </div>
</body>
</html>
