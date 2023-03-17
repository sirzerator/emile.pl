<?php

return [
    'category' => [
        'name' => 'Catégorie|Catégories',
        'actions' => [
            'add' => 'Ajouter',
            'delete' => 'Supprimer',
            'edit' => 'Modifier',
            'save' => 'Enregistrer',
        ],
        'description' => [
            'all' => 'Toutes les catégories',
            'edit' => 'Modifier une catégorie',
            'new' => 'Créer une catégorie',
        ],
        'fields' => [
            'created_at' => 'Création',
            'title' => 'Titre',
            'locale' => 'Langue',
            'slug' => 'Nom système',
            'updated_at' => 'Mise-à-jour',
        ],
        'messages' => [
            'created' => 'Catégorie créée.',
            'deleted' => 'Catégorie supprimée.',
            'updated' => 'Catégorie mise-à-jour.',
        ],
    ],
    'post' => [
        'name' => 'Article|Articles',
        'actions' => [
            'add' => 'Ajouter',
            'delete' => 'Supprimer',
            'edit' => 'Modifier',
            'save' => 'Enregistrer',
        ],
        'description' => [
            'all' => 'Tous les articles',
            'edit' => 'Modifier un article',
            'new' => 'Créer un article',
        ],
        'fields' => [
            'category' => 'Catégorie',
            'content' => 'Contenu',
            'created_at' => 'Création',
            'intro' => 'Introduction',
            'locale' => 'Langue',
            'post_is_source' => "Cet article est le contenu d'origine",
            'published_at' => 'Publication',
            'slug' => 'Nom système',
            'tags' => 'Étiquettes',
            'translation' => 'Traduction',
            'title' => 'Titre',
            'updated_at' => 'Mise-à-jour',
        ],
        'messages' => [
            'created' => 'Étiquette créée.',
            'deleted' => 'Étiquette supprimée.',
            'updated' => 'Étiquette mise-à-jour.',
        ],
    ],
    'tag' => [
        'name' => 'Étiquette|Étiquettes',
        'actions' => [
            'add' => 'Ajouter',
            'delete' => 'Supprimer',
            'edit' => 'Modifier',
            'save' => 'Enregistrer',
        ],
        'description' => [
            'all' => 'Toutes les étiquettes',
            'edit' => 'Modifier une étiquette',
            'new' => 'Créer une étiquette',
        ],
        'fields' => [
            'created_at' => 'Création',
            'title' => 'Titre',
            'locale' => 'Langue',
            'slug' => 'Nom système',
            'updated_at' => 'Mise-à-jour',
        ],
        'messages' => [
            'created' => 'Étiquette créée.',
            'deleted' => 'Étiquette supprimée.',
            'updated' => 'Étiquette mise-à-jour.',
        ],
    ],
];
