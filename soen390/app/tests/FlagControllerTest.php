<?php

class FlagControllerTest extends TestCase
{
    
    /**
     * Test the API's index and ensures that response is valid JSON.
     *
     * @covers ApiNarrativeControllerTest::index
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
     * @covers ApiNarrativeControllerTest::index
     */
    public function testFlagRetrieval()
    {
        /*$narratives = Narrative::all();

        $this->assertNotEmpty($narratives);*/

    }
     /**
     * Ensure flags get created (for a Narrative).
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testFlagCreationNarrative()
    {
        $flagCreated = new Flag;

        $flagCreated->NarrativeID = 1;
        $flagCreated->CommentID = NULL;
        $flagCreated->Flags = 1;
        $flagCreated->Comment = "Test";

        $flagCreated->save();

        $insertedId = $flagCreated->id;

        $flagFetched = Flag::find($insertedId);

        $this->assertEquals(1, $flagFetched->NarrativeID);
        $this->assertEquals(NULL, $flagFetched->CommentID);
        $this->assertEquals(1, $flagFetched->Flags);
        $this->assertEquals("Test", $flagFetched->Comment);

        $flagFetched->delete();

        $flagFetched = Flag::find($insertedId);

        $this->assertNull($flagFetched);

    }
    /**
     * Ensure flags get created (for a Comment).
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testFlagCreationComment()
    {
        $flagCreated = new Flag;

        $flagCreated->NarrativeID = NULL;
        $flagCreated->CommentID = 1;
        $flagCreated->Flags = 1;
        $flagCreated->Comment = "Test";

        $flagCreated->save();

        $insertedId = $flagCreated->id;

        $flagFetched = Flag::find($insertedId);

        $this->assertEquals(NULL, $flagFetched->NarrativeID);
        $this->assertEquals(1, $flagFetched->CommentID);
        $this->assertEquals(1, $flagFetched->Flags);
        $this->assertEquals("Test", $flagFetched->Comment);

        $flagFetched->delete();

        $flagFetched = Flag::find($insertedId);

        $this->assertNull($flagFetched);

    }

}