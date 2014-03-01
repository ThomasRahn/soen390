<?php

class UserTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('User')->delete();

        User::create(array(
                'Email'       => 'thomas@rahn.ca',
                'Password'    => Hash::make('Thomas1'),
                'Name'        => 'Thomas Rahn',
                'LanguageID'  => 1,
                'PrivilegeID' => 1,
            ));
    }

}
