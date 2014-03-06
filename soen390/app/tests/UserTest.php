<?php

class UserTest extends TestCase
{

    /**
     * Ensure User gets created.
     *
     * @covers User::save
     * @covers User::find
     * @covers User::delete
     */
    public function testUserCreation()
    {
        $userCreated = new User;

        $userCreated->LanguageID = 1;
        $userCreated->Email = "Test@email.com";
        $userCreated->Password = "Test";
        $userCreated->Name = "Test";

        $userCreated->save();

        $insertedId = $userCreated->UserID;

        $userFetched = User::find($insertedId);

        $this->assertEquals(1, $userFetched->LanguageID);
        $this->assertEquals("Test@email.com", $userFetched->Email);
        $this->assertEquals("Test", $userFetched->Password);
        $this->assertEquals("Test", $userFetched->Name);

        $userFetched->delete();

        $userFetched = User::find($insertedId);

        $this->assertNull($userFetched);

    }

    /**
     * Ensure User gets created. With nulls
     *
     * @covers User::save
     * @covers User::find
     * @covers User::delete
     */
    public function testUserCreationTestNulls()
    {
        $userCreated = new User;

        $userCreated->LanguageID = NULL;
        $userCreated->Email = "Test@email.com";
        $userCreated->Password = "Test";
        $userCreated->Name = NULL;

        $userCreated->save();

        $insertedId = $userCreated->UserID;

        $userFetched = User::find($insertedId);

        $this->assertEquals(NULL, $userFetched->LanguageID);
        $this->assertEquals("Test@email.com", $userFetched->Email);
        $this->assertEquals("Test", $userFetched->Password);
        $this->assertEquals(NULL, $userFetched->Name);

        $userFetched->delete();

        $userFetched = User::find($insertedId);

        $this->assertNull($userFetched);
    }

}
