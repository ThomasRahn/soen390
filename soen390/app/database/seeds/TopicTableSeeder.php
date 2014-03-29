<?php

class TopicTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('Topic')->delete();

		$topic = Topic::create(array(
            'Name' => 'pipeline',
        ));

        $topic->translations()->save(
            new TopicTranslation(array(
                'language_id' => Language::where('Code', 'en')->first()->LanguageID,
                'translation' => 'Transporting Oil By Pipelines vs. Trains',
            ))
        );

        $topic->translations()->save(
            new TopicTranslation(array(
                'language_id' => Language::where('Code', 'fr')->first()->LanguageID,
                'translation' => 'Le transport de pétrole par pipelines contre les trains.',
            ))
        );
    }

}
