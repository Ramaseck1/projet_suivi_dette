<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement d'une Dette</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-1/2">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold">Paiement d'une Dette</h1>
            <button class="bg-red-500 text-white px-3 py-1 rounded">X</button>
        </div>
        <div class="mb-4">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="bg-green-500 text-white p-2 rounded mb-4">
                    <?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
                </div>
            <?php endif; ?>

            <div class="flex items-center mb-2">
                <label class="w-1/4 font-semibold">Client:</label>
                <div class="flex-grow border-b-2 border-gray-300"><?php echo htmlspecialchars($client->getNom() . ' ' . $client->getPrenom()); ?></div>
                <label class="w-1/4 text-center font-semibold">TEL</label>
                <div class="flex-grow border-b-2 border-gray-300"><?php echo htmlspecialchars($client->getTel()); ?></div>
            </div>

            <?php foreach ($dette as $d): ?>
            <div class="flex items-center mb-2">
                <label class="w-1/4 font-semibold">Montant Dette:</label>
                <div class="flex-grow border-b-2 border-gray-300"><?php echo htmlspecialchars($d['montant']); ?> €</div>
            </div>
            <div class="flex items-center mb-2">
                <label class="w-1/4 font-semibold">Montant Restant:</label>
                <div class="flex-grow border-b-2 border-gray-300"><?php echo htmlspecialchars($d['montant_restant']); ?> €</div>
            </div>
            <div class="flex items-center mb-2">
                <label class="w-1/4 font-semibold">Montant Versé:</label>
                <div class="flex-grow border-b-2 border-gray-300"><?php echo htmlspecialchars($d['montant_verse']); ?> €</div>
            </div>
            <?php endforeach; ?>

            <div class="border-2 border-gray-300 p-4 rounded-md">
                <h2 class="font-semibold mb-2">Ajouter un montant versé</h2>
                <form action="/client/addpaiement" method="POST" class="flex items-center">
                    <label class="mr-2">Montant:</label>
                    <input type="hidden" name="dette_id" value="<?php echo htmlspecialchars($id); ?>">
                    <input type="text" name="montant_verse" class="border-2 border-gray-300 p-2 rounded flex-grow" value="<?php echo htmlspecialchars($data['montant_verse'] ?? ''); ?>">
                    <button type="submit" class="bg-teal-500 text-black px-4 py-2 rounded ml-2">OK</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
