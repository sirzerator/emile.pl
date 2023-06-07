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
    'contact' => [
        'name' => 'Message|Messages',
        'actions' => [
            'add' => 'Ajouter',
            'delete' => 'Supprimer',
            'delete_confirmation' => 'Êtes-vous sûr de vouloir supprimer le contact de :0?',
            'edit' => 'Modifier',
            'save' => 'Enregistrer',
            'view' => 'Afficher',
        ],
        'fields' => [
            'created_at' => 'Envoi',
            'email' => 'Courriel',
            'message' => 'Message',
            'name' => 'Nom',
            'locale' => 'Langue',
        ],
    ],
    'option' => [
        'name' => 'Option|Options',
        'about' => [
            'aka' => 'Alias (AKA)',
            'availability' => 'Disponibilités',
            'bio' => 'Biographie',
            'education' => 'Éducation',
            'email' => 'Courriel',
            'job' => 'Occupation',
            'situation' => 'Situation',
            'telephone' => 'Téléphone',
        ],
        'contact' => [
            'content' => 'Contenu',
            'subtitle' => 'Sous-titre',
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
            'translation' => 'Traduction de',
            'translations' => 'Traductions',
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
