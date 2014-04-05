<?php

class TopicTest extends TestCase
{
    /**
     * @covers Topic::toResponseArray
     * @covers Topic::getTranslationsAsArray
     * @uses   Language
     */
    public function testToResponseArray()
    {
        $this->seed('LanguageTableSeeder');

        $topic = Topic::create(array(
            'Name'      => 'test-topic',
            'Published' => true,
        ));

        $topic->translations()->save(new TopicTranslation(array(
            'language_id' => Language::where('Code', 'en')->first()->LanguageID,
            'translation' => 'english translation',
        )));

        $topic->translations()->save(new TopicTranslation(array(
            'language_id' => Language::where('Code', 'fr')->first()->LanguageID,
            'translation' => 'french translation',
        )));

        $result = $topic->toResponseArray();

        $this->assertEquals($topic->TopicID, $result['id']);
        $this->assertEquals($topic->Name, $result['name']);
        $this->assertEquals($topic->Published, $result['published']);
        $this->assertEquals(
            $topic->translations()->inLocale('en')->first()->translation,
            $result['descriptions']['en']['translation']
        );
    }
}
