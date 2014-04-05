<?php

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('User')->delete();

        // Create the default administrator user
        User::create(array(
            'Email'      => 'admin@user.local',
            'Password'   => Hash::make('admin'),
            'Name'       => 'Administrator',
            'LanguageID' => 1,
        ));

        // Set the support email to a default.
        Configuration::set('supportEmail', 'admin@user.local');
    }

}
