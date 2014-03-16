<?php

class TranscodeAudioTest extends TestCase
{

    /**
     * Test call fire call to the transcode job.
     *
     * @covers TranscodeAudio::fire
     * @covers TranscodeAudio::createMediaInstance
     */
    public function testFireWithTranscodeEnabled()
    {
        Config::set('media.transcode', true);
        Config::set('app.debug', false);

        $fileOriginal = File::getFacadeRoot();
        $file = Mockery::mock('Illuminate\Filesystem\Filesystem[delete]');
        $file->shouldReceive('delete')->andReturn(true);
        File::swap($file);

        $sonus = Mockery::mock('Rafasamp\Sonus\Sonus');
        $sonus->shouldReceive('getMediaInfo')->andReturn(array('format' => array('duration' => '0:0:0.5')));
        $sonus->shouldReceive('convert')->andReturn($sonus);
        $sonus->shouldReceive('input')->andReturn($sonus);
        $sonus->shouldReceive('output')->andReturn($sonus);
        $sonus->shouldReceive('go')->andReturn(true);
        Sonus::swap($sonus);

        $this->addNarrativeToDatabase();

        File::swap($fileOriginal);

        $this->assertCount(1, Narrative::all());
        $this->assertCount(16, Narrative::first()->media()->audio()->get());
    }

    /**
     * Test call fire call to the transcode job.
     *
     * @covers TranscodeAudio::fire
     * @covers TranscodeAudio::createMediaInstance
     */
    public function testFireWithTranscodeDisabled()
    {
        Config::set('media.transcode', false);
        Config::set('app.debug', false);

        $fileOriginal = File::getFacadeRoot();
        $file = Mockery::mock('Illuminate\Filesystem\Filesystem[delete]');
        $file->shouldReceive('delete')->andReturn(true);
        File::swap($file);

        $sonus = Mockery::mock('Rafasamp\Sonus\Sonus');
        $sonus->shouldReceive('getMediaInfo')->andReturn(array('format' => array('duration' => '0:0:0.5')));
        Sonus::swap($sonus);

        $this->addNarrativeToDatabase();

        File::swap($fileOriginal);

        $this->assertCount(1, Narrative::all());
        $this->assertCount(8, Narrative::first()->media()->audio()->get());
    }

}
