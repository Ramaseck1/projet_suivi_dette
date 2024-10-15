<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste Paiement d'une Dette</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class=" flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded shadow-lg relative w-96">
        <h2 class="text-center text-lg font-semibold mb-4">Liste Paiement d’une dette</h2>
        <div class="mb-4">
            <label class="block font-medium">Client : <?php echo htmlspecialchars($client->getNom() . ' ' . $client->getPrenom()); ?></label>
            <?php foreach ($dette as $dettel): ?>
            <span class="inline-block w-full border-b-2 border-gray-300 mb-2"></span>
            <label class="block font-medium">Mont :<?php echo htmlspecialchars($dettel['montant']); ?></label>
            <span class="inline-block w-full border-b-2 border-gray-300 mb-2"></span>
            <label class="block font-medium">Mont R :<?php echo htmlspecialchars($dettel['montant_restant']); ?></label>
            <span class="inline-block w-full border-b-2 border-gray-300"></span>
            <?php endforeach; ?>
        </div>

        <table class="w-full border-collapse border border-gray-300 mb-4">
            <thead>
                <tr>

                    <th class="border border-gray-300 p-2">Date</th>
                    <th class="border border-gray-300 p-2">Montant</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($paiements as $paiement): ?>

                <tr>

                    <td class="border border-gray-300 p-2"><?php echo htmlspecialchars($paiement['date']); ?></td>
                    <td class="border border-gray-300 p-2"><?php echo htmlspecialchars($paiement['montant_verse']); ?></td>
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
        <label class="block font-medium">Mont R :</label>
        <span class="inline-block w-full border-b-2 border-gray-300"></span>
    </div>
</body>
</html>
