<?php

class TopicTest extends TestCase
{

    /**
     * Ensure Topic gets created.
     *
     * @covers Topic::save
     * @covers Topic::delete
     * @covers Topic::find
     */
    public function testCategoryCreation()
    {
        $topicCreated = new Topic;

        $date = new DateTime;

        $topicCreated->Description = "Test";
        $topicCreated->DateCreated = $date;
        $topicCreated->DateModified = $date;
        $topicCreated->Name = "Test";

        $topicCreated->save();

        $insertedId = $topicCreated->TopicID;

        $topicFetched = Topic::find($insertedId);

        $this->assertEquals("Test", $topicFetched->Description);
        $this->assertEquals("Test", $topicFetched->Name);

        $topicFetched->delete();

        $topicFetched = Topic::find($insertedId);

        $this->assertNull($topicFetched);

    }

}
