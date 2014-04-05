<?php

class LanguageTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');
    }

    /**
     * @covers Language::narrative
     */
    public function testLanguageNarrativesRelation()
    {
        $languageCreated = new Language;
        $languageCreated->Description = "Test";
        $languageCreated->Code = "Test";
        $languageCreated->save();

        $narrativeCreated = new Narrative;

        $date = date('Y-m-d H:i:s');

        $narrativeCreated->TopicID = 1;
        $narrativeCreated->CategoryID = 1;
        $narrativeCreated->LanguageID = $languageCreated->LanguageID;
        $narrativeCreated->DateCreated = $date;
        $narrativeCreated->Name = "Test";
        $narrativeCreated->Agrees = 1;
        $narrativeCreated->Disagrees = 1;
        $narrativeCreated->Indifferents = 1;
        $narrativeCreated->Published = true;

        $narrativeCreated->save();

        $narratives = $languageCreated->narrative();
        $this->assertCount(1, $narratives->get());
    }
}
