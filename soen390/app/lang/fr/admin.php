<?php

return array(

    'sidebar' => array(
            'uploadNarratives' => 'Télécharger les récits',
            'dashboard' => 'Tableau de bord',
            'narratives' => 'Gérer les récits',
            'categories' => 'Gérer les catégories',
            'flagReports' => 'Signaler',
            'configuration' => 'Configuration du site',
            'openMainSite' => 'Voir la page principale',
            'signOut' => 'Déconnection',
            'profile' => 'Profil',
        ),
  'comments' => array(
            'table' => array(
                    'name' => 'Nom',
                    'views' => 'Vues',
                    'comment' => 'Commentaire',
                    'agrees' => 'Pour',
                    'disagrees' => 'Contre'
                )
        ),


    'narratives' => array(
            'table' => array(
                    'name' => 'Nom',
                    'views' => 'Vues',
                    'comments' => 'Commentaires',
                    'category' => 'Catégorie',
                    'createdAt' => 'Créé le',
                    'uploadedOn' => 'Téléchargé le',
                    'published' => 'Publié le',
                    'manage' => 'Gérer',
                    'comment'=> 'Commentaire',
                    'empty' => 'Vous devez télécharger les récits',
                    'loading' => 'Chargement du récit',
                    'inTotal' => 'Nombre total de récit(s).',
                    'totalFlags' => 'Nombre total de signalement(s).',
                    'narrativeName'=> 'Nom du récit',
                    'flags' => 'Signalements',
                ),

            'tips' => array(
                    'tip' => 'Astuce!',
                    'updateNarrative' => '<ul><li>Vous pouvez alterner entre les statuts de publication de chaque récit en cliquant sur <i class="fa fa-check-square-o"></i> et <i class="fa fa-square-o"></i>-icon.</li><li>La catégorie peut être changée en cliquant sur l\'étiquette actuelle.</li><li>Chaque colonne peut être triée en cliquant sur leurs en-têtes respectives.</li>',
                ),

            'update' => array(
                    'error' => 'Une erreur est survenue lors du téléchargement de ce récit.',
                ),

            'upload' => array(
                    'help' => array(
                            'archive' => 'Sélectionner le fichier contenant le(s) récit(s) que vous souhaitez télécharger. Seuls les fichiers .ZIP sont acceptés pour le moment. Le fichier doit être de <strong>:limit</strong> ou moins.',
                            'category' => 'Sélectionner la catégorie qui s\'appliquera à tous les récits du fichier. Ce paramètre peut être modifié de façon individuelle par la suite.',
                            'publish' => 'Souhaitez-vous que les récits téléchargés soient publiés et mis en ligne dès maintenant? Vous pouvez publier/retirer chaque récit de façon individuelle par la suite.',
                        ),
                    'submit' => 'Télécharger le fichier',
                    'close' => 'Fermer',
                    'uploading' => array(
                            'pleaseWait' => 'Téléchargement en cours, veuillez attendre s\'il-vous-plaît',
                            'mayTakeAWhile' => 'Il est possible que le téléchargement prenne plus de temps si le fichier est volumineux.',
                        ),
                    'uploaded' => array(
                            'success' => 'Votre fichier a été téléchargé!',
                            'successQueued' => 'Le fichier est actuellement en attente pour traitement ultérieur et sera disponible sous peu.',
                            'failed' => 'Une erreur est survenue lors du processus de téléchargement.',
                            'failedSorry' => 'Nous nous excusons pour le désagrément occasionné. Le message d\'erreur est le suivant:',
                        ),
                ),
        ),

    'configuration' => array(
            'saveSettings'  => 'Paramètres de sauvegarde',
            'resetSettings' => 'Annuler les changements',

            'save' => array(
                    'success' => '<p>Les paramètres ont été mis à jour avec succès.</p>',
                    'failed'  => '<p>Impossible de sauvegarder les paramètres dû à une erreur interne.</p>',
                ),

            'maintenance' => array(
                    'description' => 'Permettre le mode de maintenance fermera l\'interface client et affichera une page de maintenance aux utilisateurs. Ceci vous permet de procéder à des changements majeurs au niveau du système, sans potentiellement affecter les utilisateurs ou d\'avoir à fermer le site temporairement.',
                    'legend'      => 'Mode de maintenance',
                    'label'       => 'Autoriser le mode de maintenance?',
                    'help'        => 'L\'interface administrative sera toujours disponible.',
                ),

            'supportEmail' => array(
                    'description' => 'Cette valeur déterminera l\'adresse du destinataire du lien pour le courriel soutien sur le site client.',
                    'legend'      => 'Courriel de soutien',
                    'label'       => 'Adresse courriel',
                ),
        ),

    'profile' => array(

            'form' => array(
                    'name' => 'Nom',
                    'email' => 'Adresse courriel',
                    'language' => 'Langue',
                    'newPassword' => 'Nouveau mot de passe',
                    'confirmPassword' => 'Confirmer le mot de passe',
                    'saveChanges' => 'Sauvegarder les changements',
                    'undoChanges' => 'Annuler les changements',
                    'changePasswordTip' => '<p class="lead">Changer de mot de passe</p><p>Les champs pour le mot de passe ne doivent être remplis <strong>que si</strong> vous souhaitez changer votre mot de passe. Si vous ne souhaitez pas changer votre mot de passe, vous pouvez simplement les laisser vides.</p>',
                ),

            'postIndex' => array(
                    'validationFails' => '<p>Il y a une erreur dans votre formulaire. Veuillez la corriger et essayer de nouveau.</p>',
                    'internalError'   => '<p>Impossible de sauvegarder vos changements dû à une erreur interne.</p>',
                    'success'         => '<p>Votre profil a été mis à jour avec succès.</p>',
                ),

        ),

    'profile' => array(

            'form' => array(
                    'name' => 'Nom',
                    'email' => 'Adresse courriel',
                    'language' => 'Langue',
                    'newPassword' => 'Nouveau mot de passe',
                    'confirmPassword' => 'Confirmer le mot de passe',
                    'saveChanges' => 'Sauvegarder les changements',
                    'undoChanges' => 'Annuler les changements',
                    'changePasswordTip' => '<p class="lead">Changer de mot de passe</p><p>Les champs pour le mot de passe ne doivent être remplis <strong>que si</strong> vous souhaitez changer votre mot de passe. Si vous ne souhaitez pas changer votre mot de passe, vous pouvez simplement les laisser vides.</p>',
                ),

            'postIndex' => array(
                    'validationFails' => '<p>Il y a une erreur dans votre formulaire. Veuillez la corriger et essayer de nouveau.</p>',
                    'internalError'   => '<p>Impossible de sauvegarder vos changements dû à une erreur interne.</p>',
                    'success'         => '<p>Votre profil a été mis à jour avec succès.</p>',
                ),

        ),

);