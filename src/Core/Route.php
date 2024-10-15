<?php

namespace Ramaseck\ProjetSuiviDette3Mvc\Core;


use ReflectionClass;
use ReflectionException;

class Route {
    private array $routes = [];

    public function ajouterRoute(string $chemin, string $controleur, string $methode) {
        $this->routes[$chemin] = [
            'controleur' => $controleur,
            'methode' => $methode
        ];
    }

    public function routers(string $chemin) {
        foreach ($this->routes as $route => $details) {
            if ($route === $chemin) {
                $nomControleur = $details['controleur'];
                $nomMethode = $details['methode'];
                
                try {
                    $classeReflection = new ReflectionClass($nomControleur);

                    if ($classeReflection->isInstantiable()) {
                        $controleur = $classeReflection->newInstance();

                        if ($classeReflection->hasMethod($nomMethode)) {
                            $methodeReflection = $classeReflection->getMethod($nomMethode);

                            if ($methodeReflection->isPublic()) {
                                $methodeReflection->invoke($controleur);
                                return;
                            } else {
                                echo "404 - Méthode non publique pour le chemin";
                                return;
                            }
                        } else {
                            echo "404 - Méthode non trouvée pour le chemin";
                            return;
                        }
                    } else {
                        echo "404 - Contrôleur non instanciable pour le chemin";
                        return;
                    }
                } catch (ReflectionException $e) {
                    echo "404 - Erreur de réflexion : " . $e->getMessage();
                    return;
                }
            }
        }

        echo "404 - Chemin non trouvé";
    }
}

?>
