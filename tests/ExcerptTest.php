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

    public function notNumericProvider()
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
            array("This excerpt", "This excerpt", 0),
            array("This excerpt", "This excerpt", "0"),
            array("T", "This excerpt", 1),
            array("T", "This excerpt", "1"),
        );
    }

    public function assertTextLimited($to, $from, $limit)
    {
        $this->excerpt->setText($from);
        $limited = $this->excerpt->limit($limit);
        $this->assertEquals($to, $limited);
    }

    public function testLimitReturnsString()
    {
        $limited = $this->excerpt->limit();
        $this->assertInternalType('string', $limited);
    }

    /**
     * @dataProvider notAStringProvider
     * @expectedException InvalidArgumentException
     */
    public function testSetTextThrowsExecptionWhenArgIsNotString($notAString)
    {
        $this->excerpt->setText($notAString);
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
     * @dataProvider notNumericProvider
     * @expectedException InvalidArgumentException
     */
    public function testLimitThrowsExceptionWhenArgIsNotNumeric($notNumeric)
    {
        $this->excerpt->limit($notNumeric);
    }

    /**
     * @dataProvider excerptAndLimitProvider
     */
    public function testLimitReturnsExpectedNumberOfCharacters($to, $from, $limit)
    {
        $this->assertTextLimited($to, $from, $limit);
    }

    public function testLimitReturnsExpectedEnding()
    {
        $to = "T...";
        $from = "This excerpt";
        $limit = 1;
        $this->excerpt->setEnding('...');
        $this->assertTextLimited($to, $from, $limit);
    }
}   
