## Développer une mini API REST

### Modélisation de l'API
Voici la liste des endpoints que je vais mettre en place pour l'API demandée:

| Méthode HTTP | Route                       | Action                                                   | Payload                         | Réponse                                                        |  
|--------------|-----------------------------|----------------------------------------------------------|---------------------------------|----------------------------------------------------------------|
| GET          | /users/{id}                 | Récupérer un utilisateur                                 | -                               | { id, name, email }                                            |
| GET          | /tasks/{id}                 | Récupérer une tâche                                      | -                               | { id, user_id, title, description, creation_date, status }     |
| GET          | /users/{id}/tasks           | Récupérer les tâches d'un utilisateur                    | -                               | [ { id, user_id, title, description, creation_date, status } ] |
| POST         | /users/{id}/tasks           | Créer et ajouter une nouvelle tâche pour un utilisateur  | { title, description, status }  | { id, user_id, title, description, creation_date, status }     |
| DELETE       | /users/{id}/tasks/{taskId}  | Supprimer une tâche                                      | -                               | -                                                              |


## Hameçon

Pour pouvoir informer le partenaire de manière automatisée, je propose qu'on mette en place un webhook. Il faut que le partenaire ait un endpoint sur lequel envoyer une requête POST avec les données qu'il attend. Et de notre côté, dans notre application, il faut ajouter un écouteur d'évènement qui déclenche cette requête lorsqu'une création de carte se produit.

## Conception d'une base de données SQL pour une banque

### Schéma conceptuel

Pour le schéma conceptuel j'ai choisi le modèle Merise MCD:



### Clés primaires et clés étrangères
### Exemples de requête SQL