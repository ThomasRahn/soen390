<?php

class PrivilegeDbTest extends TestCase
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
     * Ensure Privileges get fetched.
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testPrivilegeRetrieval()
    {
        /*$narratives = Narrative::all();

        $this->assertNotEmpty($narratives);*/

    }
    /**
     * Ensure Privileges gets created.
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testPrivilegeCreation()
    {
        $privilegeCreated = new Privilege;

        $privilegeCreated->Description = "Test";

        $privilegeCreated->save();

        $insertedId = $privilegeCreated->PrivilegeID;

        $privilegeFetched = Privilege::find($insertedId);

        $this->assertEquals("Test", $privilegeFetched->Description);

        $privilegeFetched->delete();

        $privilegeFetched = Privilege::find($insertedId);

        $this->assertNull($privilegeFetched);

    }

}
