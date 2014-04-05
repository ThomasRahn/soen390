<?php

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('LanguageTableSeeder');
        $this->call('UserTableSeeder');
        $this->call('CategoryTableSeeder');
        $this->call('TopicTableSeeder');
    }

}
