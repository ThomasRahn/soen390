<?php

class CategoryTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');
    }

    /**
     * Ensure Category gets created.
     * @covers Category::save
     * @covers Category::create
     * @covers Category::delete
     */
    public function testCategoryCreation()
    {
        $categoryCreated = new Category;

        $categoryCreated->Description = "Test";

        $categoryCreated->save();

        $insertedId = $categoryCreated->CategoryID;

        $categoryFetched = Category::find($insertedId);

        $this->assertEquals("Test", $categoryFetched->Description);

        $categoryFetched->delete();

        $categoryFetched = Category::find($insertedId);

        $this->assertNull($categoryFetched);
    }

   /**
     * Ensure Category gets created.
     * @covers Category::narrative
     */
    public function testCategoryNarrativesRelation()
    {
        $categoryCreated = new Category;
        $categoryCreated->Description = "Test";
        $categoryCreated->save();

        $narrativeCreated = new Narrative;

        $date = date('Y-m-d H:i:s');

        $narrativeCreated->TopicID = 1;
        $narrativeCreated->CategoryID = $categoryCreated->CategoryID;
        $narrativeCreated->LanguageID = 1;
        $narrativeCreated->DateCreated = $date;
        $narrativeCreated->Name = "Test";
        $narrativeCreated->Agrees = 1;
        $narrativeCreated->Disagrees = 1;
        $narrativeCreated->Indifferents = 1;
        $narrativeCreated->Published = true;

        $narrativeCreated->save();

        $narratives = $categoryCreated->narrative();
        $this->assertTrue($narratives->count() > 0);
    }

}
