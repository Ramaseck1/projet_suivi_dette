<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dette</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class=" mx-auto bg-white p-20 rounded-lg">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Dette</h1>
        </div>
        <?php if (($client)): ?>       <div class="mt-4">
                <div class="flex space-x-4">
                    <div>
            <p class="block font-medium">Client : <?php echo htmlspecialchars($client->getNom() . ' ' . $client->getPrenom()); ?></p>                    </div>
                    <div>
                        <p  class="block font-medium">Telephone : <?php echo htmlspecialchars($client->getTel()); ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <div class="mt-4">
                    <label for="statut" class="block font-medium">Statut</label>
                    <input type="text" id="statut" class="border rounded w-full p-1">
                </div>
                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full border border-black">
                        <thead>
                            <tr>
                                <th class="border border-black px-4 py-2">Date</th>
                                <th class="border border-black px-4 py-2">Montant</th>
                                <th class="border border-black px-4 py-2">Restant</th>
                                <th class="border border-black px-4 py-2">Paiement</th>
                                <th class="border border-black px-4 py-2">Liste Paiement</th>
                                <th class="border border-black px-4 py-2">Article</th>
                            </tr>
                        </thead>
                        <?php if (($dettes)): ?>
                        <tbody>
                            <?php foreach ($dettes as $detail): ?>
                                <tr>
                                    <td class="border border-black px-4 py-2"><?php echo htmlspecialchars($detail['date']); ?></td>
                                    <td class="border border-black px-4 py-2"><?php echo htmlspecialchars($detail['montant']); ?></td>
                                    <td class="border border-black px-4 py-2"><?php echo htmlspecialchars($detail['montant_restant']); ?></td>
                                    <td class="border border-black px-4 py-2 text-center">
                                    <form action="/client/addpaiement" method="POST">
                                        <button class="bg-blue-500 text-white px-3 py-1 rounded" name="paye" value="<?php echo htmlspecialchars($detail['id']); ?>
                                        " >Payer</button></form>
                                    </td>
                                    <td class="border border-black px-4 py-2 text-center">
                                        <form action="/client/paimentliste" method="post">
                                        <button value="<?php echo htmlspecialchars($detail['id']); ?>
                                        " name="liste" class="bg-green-500 text-white px-3 py-1 rounded">Liste</button></form>
                                    </td>
                                    <td class="border border-black px-4 py-2 text-center">
                                    <form action="/client/article" method="post">
                                        <button value="<?php echo htmlspecialchars($detail['id']); ?>
                                        " class="bg-purple-500 text-white px-3 py-1 rounded" name="views">Views</button></form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
    <p>Aucun client trouvé.</p>
<?php endif; ?>
        </div>
    </div>
</body>
</html>
