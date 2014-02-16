<?php

return array(

    'sidebar' => array(
            'uploadNarratives' => 'Upload Narrative(s)',
            'dashboard' => 'Dashboard',
            'narratives' => 'Narratives',
            'categories' => 'Categories',
            'flagReports' => 'Flag Reports',
            'configuration' => 'Configuration',
            'openMainSite' => 'Open Main Site',
            'signOut' => 'Sign Out',
        ),

    'narratives' => array(
            'table' => array(
                    'name' => 'Name',
                    'views' => 'Views',
                    'comments' => 'Comments',
                    'category' => 'Category',
                    'uploadedOn' => 'Uploaded On',
                    'manage' => 'Manage',
		    'comment'=> 'Comment',
                    'empty' => 'You need to upload some narratives first!',
                    'loading' => 'Loading narratives...',
                    'inTotal' => 'narrative(s) in total.',
		    'totalFlags' => 'flag(s) in total.',
		    'narrativeName'=>'Narrative Name'
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

);
