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
            ));

	User::create(array(
		'Email'	      => 'french@french.ca',
		'Password'    => Hash::make('French1'),
		'Name'        => 'Jacque TRrembly',
		'LanguageID'  => 2
	));
    }

}
