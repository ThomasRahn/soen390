<?php

return array(
    'youdeliberate' => 'You Deliberate',
    'logo'          => 'You <i class="fa fa-comments"></i> Deliberate',

    'sidebar' => array(
        'uploadNarratives' => 'Upload Narrative(s)',
        'dashboard'        => 'Google Analytics',
        'narratives'       => 'Manage Narratives',
        'categories'       => 'Manage Categories',
        'flagReports'      => 'Flag Reports',
        'configuration'    => 'Site Configuration',
        'openMainSite'     => 'View User Site',
        'signOut'          => 'Sign Out',
        'profile'          => 'Profile',
        'topics'           => 'Manage Topics',
    ),

    'dashboard' => array(
            'open' => 'Open Google Analytics',
        ),

    'comments' => array(
            'table' => array(
                    'name' => 'Name',
                    'views' => 'Views',
                    'comment' => 'Comment',
                    'agrees' => 'Agrees',
                    'disagrees' => 'Disagrees'
                )
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
                    'topic' => 'Topic',
                    'language' => 'Language',
                ),

            'tips' => array(
                    'tip' => 'Tip!',
                    'updateNarrative' => '<ul><li>You can toggle the publication status of each narrative by clicking on the <i class="fa fa-check-square-o"></i> and <i class="fa fa-square-o"></i>-icon.</li><li>The Category can be changed by clicking on the current label.</li><li>Each column can be sorted by clicking on their respective headers.</li>',
                ),

            'update' => array(
                    'error' => 'An error occured while attempting to update this narrative.',
                ),

            'upload' => array(
                    'form' => array(
                            'archive'  => 'Archive File',
                            'category' => 'Default Category',
                            'publish'  => 'Publish on Upload?',
                            'topic'    => 'Associated Topic',
                        ),
                    'help' => array(
                            'archive'  => 'Select the archive file which contains the narrative(s) that you want to upload. Only .ZIP files are supported at this moment. Archive file must be <strong>:limit</strong> or smaller.',
                            'category' => 'Select the category that will be applied to all narratives found in the archive. This can be changed individually after.',
                            'publish'  => 'Would you like the uploaded narratives to be published and made available on the site immediately? You can publish/unpublish each narrative individually later.',
                            'topic'    => 'Select the topic that the uploaded narratives will be associated with.',
                        ),
                    'submit' => 'Upload Archive',
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
                    'archiveFile'=>'Archive File',
                    'defaultCategory'=>'Default Category',
                    'publishOnUpload'=>'Publish on Upload',
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

            'supportEmail' => array(
                    'description' => 'This value will determine the recipient address for the support email link on the client site.',
                    'legend'      => 'Support Email',
                    'label'       => 'Email Address',
                ),

            'validator' => array(
                    'fails' => 'There is a mistake in one of the configuration fields. Please correct it and try to save again.',
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

    'topic' => array(
        'index' => array(
            'table' => array(
                'code'        => 'Code',
                'description' => 'Description',
                'narratives'  => 'Child Narratives',
                'manage'      => 'Manage',
                'add'         => 'Add a new topic',
                'published'   => 'Published?',
            ),

            'addModal' => array(
                'title'        => 'Add a New Topic',
                'code'         => 'Topic Code',
                'descEn'       => 'Description (English)',
                'descFr'       => 'Description (French)',
                'addButton'    => 'Add Topic',
                'cancelButton' => 'Cancel',
            ),

            'editModal' => array(
                'title'      => 'Edit a Topic',
                'saveButton' => 'Save Changes',
            ),
        ),

        'add' => array(
            'saveFailed' => 'Unable to save Topic instance due to server error.',
        ),

        'delete' => array(
            'success'    => 'Topic <code>:code</code> has been deleted. All previously narratives have been moved into the <code>:first</code> topic.',
            'failure'    => 'Failed to delete topic <code>:code</code> due to a server side error. Changes have not been saved.',
            'atleastOne' => 'There needs to be at least <strong>one</strong> remaining topic.',
        ),

        'togglePublish' => array(
            'failure' => 'Failed to toggle publication status on topic <code>:code</code> due to a server side error. Please try again later.',
        ),
    ),

);
