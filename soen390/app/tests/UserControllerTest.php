<?php

class UserControllerTest extends TestCase
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
     * Ensure users get fetched.
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testUserRetrieval()
    {
        /*$narratives = Narrative::all();

        $this->assertNotEmpty($narratives);*/

    }
    /**
     * Ensure User gets created.
     *
     * @covers ApiNarrativeControllerTest::index
     */
    public function testUserCreation()
    {
        $userCreated = new User;

        $userCreated->PrivilegeID = 1;
        $userCreated->LanguageID = 1;
        $userCreated->Email = "Test@email.com";
        $userCreated->Password = "Test";
        $userCreated->Name = "Test";

        $userCreated->save();

        $insertedId = $userCreated->id;

        $userFetched = User::find($insertedId);

        $this->assertEquals(1, $userFetched->PrivilegeID);
        $this->assertEquals(1, $userFetched->LanguageID);
        $this->assertEquals("Test@email.com", $userFetched->Email);
        $this->assertEquals("Test", $userFetched->Password);
        $this->assertEquals("Test", $userFetched->Name);

        $userFetched->delete();

    }
    /**
     * Ensure User gets created. With nulls
     *
     * @covers ApiNarrativeControllerTest::index
     */
     public function testUserCreationTestNulls()
    {
        $userCreated = new User;

        $userCreated->PrivilegeID = 1;
        $userCreated->LanguageID = NULL;
        $userCreated->Email = "Test@email.com";
        $userCreated->Password = "Test";
        $userCreated->Name = NULL;

        $userCreated->save();

        $insertedId = $userCreated->id;

        $userFetched = User::find($insertedId);

        $this->assertEquals(1, $userFetched->PrivilegeID);
        $this->assertEquals(NULL, $userFetched->LanguageID);
        $this->assertEquals("Test@email.com", $userFetched->Email);
        $this->assertEquals("Test", $userFetched->Password);
        $this->assertEquals(NULL, $userFetched->Name);

        $userFetched->delete();
    }


}
