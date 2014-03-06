<?php

return array(

    'sidebar' => array(
            'uploadNarratives' => 'Upload Narrative(s)',
            'dashboard' => 'Google Analytics',
            'narratives' => 'Manage Narratives',
            'categories' => 'Manage Categories',
            'flagReports' => 'Flag Reports',
            'configuration' => 'Site Configuration',
            'openMainSite' => 'View User Site',
            'signOut' => 'Sign Out',
            'profile' => 'Profile',
        ),

    'narratives' => array(
            'table' => array(
                    'name' => 'Name',
                    'views' => 'Views',
                    'comments' => 'Comments',
                    'category' => 'Category',
                    'createdAt' => 'Recorded On',
                    'uploadedOn' => 'Uploaded On',
                    'published' => 'Published?',
                    'manage' => 'Manage',
		            'comment'=> 'Comment',
                    'empty' => 'You need to upload some narratives first!',
                    'loading' => 'Loading narratives...',
                    'inTotal' => 'narrative(s) in total.',
		            'totalFlags' => 'flag(s) in total.',
		            'narrativeName'=> 'Narrative Name',
                    'flags' => 'Flags',
                ),

            'tips' => array(
                    'tip' => 'Tip!',
                    'updateNarrative' => 'You can toggle the publication status of each narrative by clicking on the <i class="fa fa-check-square-o"></i> and <i class="fa fa-square-o"></i>-icon. The Category can be changed by clicking on the current label.',
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
                    'submit' => 'Upload Narrative(s)',
                    'close' => 'Close',
                    'uploading' => array(
                            'pleaseWait' => 'Uploading, please wait...',
                            'mayTakeAWhile' => 'This may take a while based on how large the selected file is.',
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
            'saveSettings'  => 'Save Settings',
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

);
