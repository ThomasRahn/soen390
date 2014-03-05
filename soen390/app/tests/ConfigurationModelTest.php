<?php

class ConfigurationModelTest extends TestCase
{

    /**
     * Tests the overridden `get` function and ensures that attempts to
     * retrieve a configuration key that does not exist returns the
     * specified default value.
     *
     * @covers Configuration::get
     */
    public function testGetWithNonExistentConfigAndDefaultValue()
    {
        $defaultValue = 'non-existing configuration';

        $retrievedValue = Configuration::get('nonExistent', $defaultValue);

        $this->assertEquals($defaultValue, $retrievedValue);
    }

    /**
     * Tests the `set` function and ensures that new configuration that is
     * set, then exists and is valid.
     *
     * @covers Configuration::set
     */
    public function testSetWithNewConfig()
    {
        $key   = 'setting';
        $value = 'option';

        $setResult = Configuration::set($key, $value);

        $this->assertInstanceOf('Configuration', $setResult);
        $this->assertNotNull(Configuration::find($key));
        $this->assertEquals($value, Configuration::find($key)->value);
    }

    /**
     * Tests the `set` function and ensures that updating an existing
     * configuration works and affects a single configuration instance.
     * Also checks to see that the `get` configuration works properly
     * on an existing configuration value.
     *
     * @covers Configuration::set
     * @covers Configuration::get
     */
    public function testSetAndGetWithWithExistingConfig()
    {
        $key = 'setting';

        Configuration::set($key, 'option1');

        Configuration::set($key, 'option2');

        $this->assertCount(1, Configuration::where('key', $key)->get());
        $this->assertEquals('option2', Configuration::get($key));
    }

}
