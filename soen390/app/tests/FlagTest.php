<?php

class FlagTest extends TestCase
{
    
    /**
     * Test the API's index and ensures that response is valid JSON.
     *
     */
    public function testIndex()
    {
        /*$response = $this->call('GET', 'api/topic');

        $this->assertResponseOk();

        json_decode($response->getContent());

        $this->assertEquals(JSON_ERROR_NONE, json_last_error());*/
    }
    /**
     * Ensure flags get fetched.
     *
     */
    public function testFlagRetrieval()
    {
        /*$narratives = Narrative::all();

        $this->assertNotEmpty($narratives);*/

    }
     /**
     * Ensure flags get created (for a Narrative).
     * @covers Flag::save
     * @covers Flag::create
     * @covers Flag::delete
     */
    public function testFlagCreationNarrative()
    {
        $flagCreated = new Flag;

        $flagCreated->NarrativeID = 1;
        $flagCreated->CommentID = NULL;
        $flagCreated->Comment = "Test";

        $flagCreated->save();

        $insertedId = $flagCreated->FlagID;

        $flagFetched = Flag::find($insertedId);

        $this->assertEquals(1, $flagFetched->NarrativeID);
        $this->assertEquals(NULL, $flagFetched->CommentID);
        $this->assertEquals("Test", $flagFetched->Comment);

        $flagFetched->delete();

        $flagFetched = Flag::find($insertedId);

        $this->assertNull($flagFetched);

    }
    /**
     * Ensure flags get created (for a Comment).
     *
     */
    public function testFlagCreationComment()
    {
        $flagCreated = new Flag;

        $flagCreated->NarrativeID = NULL;
        $flagCreated->CommentID = 1;
        $flagCreated->Comment = "Test";

        $flagCreated->save();

        $insertedId = $flagCreated->FlagID;

        $flagFetched = Flag::find($insertedId);

        $this->assertEquals(NULL, $flagFetched->NarrativeID);
        $this->assertEquals(1, $flagFetched->CommentID);
        $this->assertEquals("Test", $flagFetched->Comment);

        $flagFetched->delete();

        $flagFetched = Flag::find($insertedId);

        $this->assertNull($flagFetched);

    }

}
