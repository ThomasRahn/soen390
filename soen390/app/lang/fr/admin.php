<?php

return array(

    'sidebar' => array(
            'uploadNarratives' => 'Telecharger Narrative(s)',
            'dashboard' => 'Google Analytics',
            'narratives' => 'Manage Narratives',
            'categories' => 'Manage Categories',
            'flagReports' => 'Flag Reports',
            'configuration' => 'Configuration du site',
            'openMainSite' => 'Voir la page client',
            'signOut' => 'Deconnection',
            'profile' => 'Profile',
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
                    'category' => 'Category',
                    'createdAt' => 'Recorded On',
                    'uploadedOn' => 'Uploaded On',
                    'published' => 'Publier?',
                    'manage' => 'Manage',
	            'comment'=> 'Commentaire',
                    'empty' => 'Il faut que vous telecharge les narrative!',
                    'loading' => 'Loading narratives...',
                    'inTotal' => 'narrative(s) in total.',
	            'totalFlags' => 'flag(s) in total.',
	            'narrativeName'=> 'Nom du narrative',
                    'flags' => 'Flags',
                ),

            'tips' => array(
                    'tip' => 'Tip!',
                    'updateNarrative' => '<ul><li>You can toggle the publication status of each narrative by clicking on the <i class="fa fa-check-square-o"></i> and <i class="fa fa-square-o"></i>-icon.</li><li>The Category can be changed by clicking on the current label.</li><li>Each column can be sorted by clicking on their respective headers.</li>',
                ),

            'update' => array(
                    'error' => 'An error occured while attempting to update this narrative.',
                ),

            'upload' => array(
                    'help' => array(
                            'archive' => 'Select the archive file which contains the narrative(s) that you want to upload. Only .ZIP files are supported at this moment. Archive file must be <strong>:limit</strong> or smaller.',
                            'category' => 'Select the category that will be applied to all narratives found in the archive. This can be changed individually after.',
                            'publish' => 'Would you like the uploaded narratives to be published and made available on the site immediately? You can publish/unpublish each narrative individually later.',
                        ),
                    'submit' => 'Upload Archive',
                    'close' => 'Fermer',
                    'uploading' => array(
                            'pleaseWait' => 'En cours, s\'il vous plait attende...',
                            'mayTakeAWhile' => 'Il pourrait prends beacoup de temps si la fichier est large.',
                        ),
                    'uploaded' => array(
                            'success' => 'Your archive has been uploaded!',
                            'successQueued' => 'It\'s currently queued for further processing and will be available soon.',
                            'failed' => 'An error occured during the upload process.',
                            'failedSorry' => ' We\'re sorry for any inconvenience caused. The following is the error message:',
                        ),
                ),
        ),

    'configuration' => array(
            'saveSettings'  => 'Sauvegarde Configurations',
            'resetSettings' => 'Undo Changes',

            'save' => array(
                    'success' => '<p>Settings have been updated successfully.</p>',
                    'failed'  => '<p>Unable to save settings due to an internal error.</p>',
                ),

            'maintenance' => array(
                    'description' => 'Enabling maintenance mode will close the client-side interface, displaying a maintenance page to users. This allows you to make major changes to the system without potentially affecting users or to temporarily take the site down.',
                    'legend'      => 'Maintenance Mode',
                    'label'       => 'Enable maintenance mode?',
                    'help'        => 'The administrative interface will always be available.',
                ),

            'supportEmail' => array(
                    'description' => 'This value will determine the recipient address for the support email link on the client site.',
                    'legend'      => 'Support Email',
                    'label'       => 'Email Address',
                ),
        ),

    'profile' => array(

            'form' => array(
                    'name' => 'Name',
                    'email' => 'Email Address',
                    'language' => 'Language',
                    'newPassword' => 'New Password',
                    'confirmPassword' => 'Confirm Password',
                    'saveChanges' => 'Save Changes',
                    'undoChanges' => 'Undo Changes',
                    'changePasswordTip' => '<p class="lead">Changing Passwords</p><p>The password fields only need to be filled-out <strong>if</strong> you want to change your password. If you do not wish to change your password, you can simply leave them blank.</p>',
                ),

            'postIndex' => array(
                    'validationFails' => '<p>There is a mistake in your form. Please correct it and try again.</p>',
                    'internalError'   => '<p>Unable to save your changes due to an internal error.</p>',
                    'success'         => '<p>Your profile has been updated successfully.</p>',
                ),

        ),

    'profile' => array(

            'form' => array(
                    'name' => 'Name',
                    'email' => 'Email Address',
                    'language' => 'Language',
                    'newPassword' => 'New Password',
                    'confirmPassword' => 'Confirm Password',
                    'saveChanges' => 'Save Changes',
                    'undoChanges' => 'Undo Changes',
                    'changePasswordTip' => '<p class="lead">Changing Passwords</p><p>The password fields only need to be filled-out <strong>if</strong> you want to change your password. If you do not wish to change your password, you can simply leave them blank.</p>',
                ),

            'postIndex' => array(
                    'validationFails' => '<p>Il y a une erreur dans votre formulare. S\'il vous plais correige et esseyer encore..</p>',
                    'internalError'   => '<p>Impossible de sauver votre information parce ce que une erreur interne.</p>',
                    'success'         => '<p>Votre profile est changer correctement.</p>',
                ),

        ),

);