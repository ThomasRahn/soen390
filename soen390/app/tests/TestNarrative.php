<?php

class TestNarrative extends TestCase {

	/**
	 * Test if a narrative gets retrieved.
	 *
	 * @return void
	 */
	public function testNarrativeRetrieval()
	{
		$narratives = Narrative::all();

		$this->assertNotEmpty($narratives->);

	}

	/**
	 * Test if a narrative gets retrieved.
	 *
	 * @return void
	 */
	public function testNarrativeJSON()
	{
		$narrative = Narrative::where('NarrativeID',1)->first();

		$this->assertNotEmpty($narratives->);

	}

	/**
	 * Test if a narrative gets retrieved.
	 *
	 * @return void
	 */
	public function testNarrativeRetrieval()
	{
		$narratives = Narrative::all();

		$this->assertNotEmpty($narratives->);

	}

}