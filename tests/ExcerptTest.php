<?php 

class ExcerptTest extends PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->excerpt = new Kouz\Excerpt();
    }

    public function notAStringProvider()
    {
        return array( 
            array(1),
            array(1.1),
            array(true),
            array(false),
            array(null),
            array(array()),
        );
    }

    public function notANumericProvider()
    {
        return array( 
            array(1.1),
            array(true),
            array(false),
            array(null),
            array(array()),
        );
    }

    public function excerptAndLimitProvider()
    {
        return array(
            array("", "", 0),
            array("No limit", "No limit", 0),
            array("No limit", "No limit", "0"),
            array("L", "Limit to 1 Character", 1),
            array("L", "Limit to 1 Character", "1"),
            array("Limit exceeds text", "Limit exceeds text", 100),
        );
    }
    
    public function excerptEndingAndLimitProvider()
    {
        return array(
            array("No limit", "No limit", "...", 0),
            array("Limit exceeds text", "Limit exceeds text", "...", 100),
            array("L...", "Limit to 1 Character", "...", 1),
            array("Limit...", "Limit ends on white space also remove", "...", 6),
        );
    }

    public function assertTextLimited($to, $from, $limit)
    {
        $this->excerpt->setLimit($limit);
        $limited = $this->excerpt->limit($from);
        $this->assertInternalType('string', $limited);
        $this->assertEquals($to, $limited);
    }

    /**
     * @dataProvider notAStringProvider
     * @expectedException InvalidArgumentException
     */
    public function testLimitThrowsExecptionWhenArgIsNotString($notAString)
    {
        $this->excerpt->limit($notAString);
    }

    /**
     * @dataProvider notAStringProvider
     * @expectedException InvalidArgumentException
     */
    public function testSetEndingThrowsExecptionWhenArgIsNotString($notAString)
    {
        $this->excerpt->setEnding($notAString);
    }

    /**
     * @dataProvider notANumericProvider
     * @expectedException InvalidArgumentException
     */
    public function testSetLimitThrowsExceptionWhenArgIsNotNumeric($notNumeric)
    {
        $this->excerpt->setLimit($notNumeric);
    }

    /**
     * @dataProvider excerptAndLimitProvider
     */
    public function testLimitReturnsExpectedNumberOfCharacters($to, $from, $limit)
    {
        $this->assertTextLimited($to, $from, $limit);
    }

    /**
     * @dataProvider excerptEndingAndLimitProvider
     */
    public function testLimitReturnsExpectedEnding($to, $from, $ending, $limit)
    {
        $this->excerpt->setEnding($ending);
        $this->assertTextLimited($to, $from, $limit);
    }
}   
