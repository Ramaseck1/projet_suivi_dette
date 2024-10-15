<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-teal-800 text-gray-900">
    <div class="">
   
        <!-- Affichage des erreurs de validation -->
  
        
        <!-- Affichage de la notification de succès -->
        <?php
        ?>
        <!-- Affichage des erreurs de validation -->
        <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Erreur! Veuillez corriger les erreurs suivantes :</strong>
                <ul>
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                    <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.172 7.066 4.238a1 1 0 10-1.414 1.414L8.828 10l-3.172 3.172a1 1 0 001.414 1.414L10 12.828l3.172 3.172a1 1 0 001.414-1.414L11.172 10l3.176-3.172z"/></svg>
                </span>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <!-- En-tête -->
        <div class="flex items-center justify-between bg-white p-4 rounded shadow">
            <div class="text-lg font-bold">Boutique</div>
           <!--  <a href="/client/enregistrer">Accueil</a>
            <a href="/client/add">Liste dette</a> -->


            <div class="flex items-center">
                <div class="w-10 h-10 bg-gray-300 rounded-full mr-2"></div>
                <div>Diallo Boutique <span class="text-sm">&#9660;</span></div>
            </div>
        </div>

        <!-- Formulaire Nouveau Client -->
        <div class="flex justify-center mt-8 space-x-8">
            <div class="bg-white p-20 rounded shadow">          
                  <?php if (isset($_SESSION['notification'])): ?>

            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Succès!</strong>
                <span class="block sm:inline"><?= $_SESSION['notification'] ?></span>

                <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                    <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.172 7.066 4.238a1 1 0 10-1.414 1.414L8.828 10l-3.172 3.172a1 1 0 001.414 1.414L10 12.828l3.172 3.172a1 1 0 001.414-1.414L11.172 10l3.176-3.172z"/></svg>
                </span>
            </div>
            <?php unset($_SESSION['notification']); ?>
        <?php endif; ?>
                <h2 class="text-center font-semibold mb-4">Nouveau client</h2>
 <form action="/client/enregistrer" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="nom" class="block text-sm font-medium">Nom</label>
                <input type="text" name="nom" id="nom" class="mt-1 block w-full p-4 border rounded" value="<?= htmlspecialchars($data['nom'] ?? '') ?>">
                <?php if (isset($errors['nom'])): ?>
                    <p class="text-red-500"><?= htmlspecialchars($errors['nom']) ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="prenom" class="block text-sm font-medium">Prénom</label>
                <input type="text" name="prenom" id="prenom" class="mt-1 block w-full p-4 border rounded" value="<?= htmlspecialchars($data['prenom'] ?? '') ?>">
                <?php if (isset($errors['prenom'])): ?>
                    <p class="text-red-500"><?= htmlspecialchars($errors['prenom']) ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium">Email</label>
                <input type="text" name="email" id="email" class="mt-1 block w-full p-4 border rounded" value="<?= htmlspecialchars($data['email'] ?? '') ?>">
                <?php if (isset($errors['email'])): ?>
                    <p class="text-red-500"><?= htmlspecialchars($errors['email']) ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="tel" class="block text-sm font-medium">Téléphone</label>
                <input type="tel" name="tel" id="tel" class="mt-1 block w-full p-4 border rounded" value="<?= htmlspecialchars($data['tel'] ?? '') ?>">
                <?php if (isset($errors['tel'])): ?>
                    <p class="text-red-500"><?= htmlspecialchars($errors['tel']) ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="photo" class="block text-sm font-medium">Photo</label>
                <input type="file" name="photo" id="photo" class="mt-1 block w-full p-4 border rounded">
                <?php if (isset($errors['photo'])): ?>
                    <p class="text-red-500"><?= htmlspecialchars($errors['photo']) ?></p>
                <?php endif; ?>
            </div>
            <div class="text-center">
                <button type="submit" class="bg-teal-600 ml-10 text-white py-2 px-4 rounded">Enregistrer</button>
            </div>
        </form>

            </div>
            <!-- Formulaire Suivi Dette -->
         
                   <!--  <?php if (isset($error)): ?>
                     <p style="color:red"><?= htmlspecialchars($error) ?></p>
                     <?php endif; ?> -->

<img src="hh.jpg" alt="hh">
            <div class="bg-white p-20 rounded shadow">
                <h2 class="text-center font-semibold mb-4">Suivi Dette</h2>
               <form method="POST" action="/client/ajouter">

                    <div class="mb-4 flex items-center space-x-2">
                         <label for="telephone" class="block text-sm font-medium">Telephone</label>
                        <input type="tel" name="tel" id="telephone" class="mt-1 block w-full p-2 border rounded flex-grow">
                        <button type="submit" class="bg-teal-600 text-white py-2 px-4 rounded">OK</button>

                    </div>
                    
                    </form>
                    <div class="flex justify-between">
                        <button type="submit"  class="bg-teal-300 text-black py-2 px-4 rounded">Client</button>
                        <form action="/client/addproduitTotable" method="POST">
                       <button type="submit"  value=" <?=$client->getId() ?? '' ?>" name="nouvelle" class="bg-teal-300 text-black py-2 px-4 rounded">Nouvelle</button></form>
                       <form action="/client/add" method="POST">
                    <button type="submit" value=" <?=$client->getId() ?? '' ?>"  name="dette" class="bg-teal-300 text-black py-2 px-4 rounded">Dette</but>
                    </form>
                    </div>
                 

                
                    <div class="bg-white p-20 rounded shadow mt-8">
                    <div class="flex ">

                    <div class="photo">
                        <img src="http://www.rama.seck:9092/img/<?php echo $client->getPhoto(); ?>" alt="" width="100px" height="100px">
                        

                </div>
                        <div>
                        <?php if ($client): ?>
    <div class="ml-10">
        <p>Nom: <?php echo $client->getNom(); ?></p>
        <p>Prénom: <?php echo $client->getPrenom(); ?></p>
        <p>Email: <?php echo $client->getEmail(); ?></p>
        <p>Téléphone: <?php echo $client->getTel(); ?></p>
        <!-- Ajoutez d'autres propriétés selon votre structure d'entité -->
    </div>
            <?php if ($dettes && count($dettes) > 0): ?>
                <div class="mt-8">
                       
                      
                            <?php foreach ($dettes as $dette): ?>
                                <div class="mt-20" style="margin-left:-100px">
                                    <p class="py-2 px-4 ">Montant total : <?php echo htmlspecialchars($dette['montant']); ?></>
                                    <p class="py-2 px-4 -">Montant versé :<?php echo htmlspecialchars($dette['montant_verse']); ?></p>
                                    <p class="py-2 px-4 ">Montant restant : <?php echo htmlspecialchars($dette['montant_restant']); ?></p>
                                    </div>
                            <?php endforeach; ?>
                       
                    
                </div>
           
              
            </div>
        </div>
        <?php else: ?>
                <p>Aucune dette trouvée pour ce client.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>Aucun client trouvé avec ce numéro de téléphone.</p>
        <?php endif; ?>

      
    </div>
</body>
</html>
