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
                ),
        ),

);
