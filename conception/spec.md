# Specifications

## Besoin client

Le premier client a enfin signé un contrat de partenariat avec BileMo! C’est le branle-bas de combat pour répondre aux besoins de ce premier client qui va permettre de mettre en place l’ensemble des API et les éprouver tout de suite.

Après une réunion dense avec le client, il a été identifié un certain nombre d’informations. Il doit être possible de:

- consulter la liste des produits BileMo
- consulter les détails d’un produit BileMo
- consulter la liste des utilisateurs inscrits liés à un client sur le site web
- consulter le détail d’un utilisateur inscrit lié à un client
- ajouter un nouvel utilisateur lié à un client
- supprimer un utilisateur ajouté par un client

Seuls les clients référencés peuvent accéder aux API. Les clients de l’API doivent être authentifiés via Oauth ou JWT.  
Vous avez le choix de mettre en place un serveur Oauth et d’y faire appel (en utilisant le FOSOAuthServerBundle) ou d’utiliser Facebook, Google ou LinkedIn. Si vous décidez d’utiliser JWT, il vous faudra vérifier la validité du token; l’usage d’une librairie est autorisée.

## Présentation des données

Le premier partenaire de BileMo est très exigeant: il requiert que vous exposiez vos données en suivant les règles des niveaux 1, 2 et 3 du modèle de Richardson. Il a demandé à ce que vous serviez les données en JSON. Si possible, le client souhaite que les réponses soient mises en cache afin d’optimiser les performances des requêtes en direction de l’API.

## Livrables

- Un lien vers l’ensemble du projet (fichiers PHP/HTML/JS/CSS…) sur un repository Github
- Diagrammes UML (modèles de données, classes, séquentiels)
- Les instructions pour installer le projet (dans un fichier README à la racine du projet)
- Les issues sur le repository Github
- Documentation technique de l’API à destination des futurs utilisateurs
