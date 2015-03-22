<?php namespace Kouz;

class TextTruncatorTest extends \PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->textTruncator = new TextTruncator();
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

    public function limitCharsProvider()
    {
        return array(
            array("", "", "", 0),
            array("No limit", "No limit", "", 0),
            array("No limit", "No limit", "", "0"),
            array("No limit", "No limit", "...", 0),
            array("L", "Limit to 1 Character", "", 1),
            array("L", "Limit to 1 Character", "", "1"),
            array("L...", "Limit to 1 Character", "...", 1),
            array("Limit exceeds text", "Limit exceeds text", "...", 100),
            array("Limit...", "Limit ends on white space also remove", "...", 6),
            array("Limit a...", "   Limit    and    ignore multiple white space   ", "...", 7),
        );
    }

    public function limitWordProvider()
    {
        return array(
            array("", "", "", 0),
            array("No word limit", "No word limit", "...", 0),
            array("Limit exceeds text", "Limit exceeds text", "...", 100),
            array("Limit two...", "Limit two words", "...", 2),
            array("Limit and...", "   Limit    and    ignore multiple white space   ", "...", 2),
        );
    }

    /**
     * @dataProvider notAStringProvider
     * @expectedException InvalidArgumentException
     */
    public function testLimitCharsThrowsExecptionWhenArgIsNotString($notAString)
    {
        $this->textTruncator->limitChars($notAString);
    }

    /**
     * @dataProvider notAStringProvider
     * @expectedException InvalidArgumentException
     */
    public function testLimitWordsThrowsExecptionWhenArgIsNotString($notAString)
    {
        $this->textTruncator->limitWords($notAString);
    }

    /**
     * @dataProvider notAStringProvider
     * @expectedException InvalidArgumentException
     */
    public function testSetEndingThrowsExecptionWhenArgIsNotString($notAString)
    {
        $this->textTruncator->setEnding($notAString);
    }

    /**
     * @dataProvider notANumericProvider
     * @expectedException InvalidArgumentException
     */
    public function testSetLimitThrowsExceptionWhenArgIsNotNumeric($notNumeric)
    {
        $this->textTruncator->setLimit($notNumeric);
    }

    /**
     * @dataProvider limitCharsProvider
     */
    public function testLimitCharsReturnsExpected($to, $from, $ending, $limit)
    {
        $this->textTruncator->setEnding($ending);
        $this->textTruncator->setLimit($limit);
        $limited = $this->textTruncator->limitChars($from);
        $this->assertInternalType('string', $limited);
        $this->assertEquals($to, $limited);
    }

       /**
     * @dataProvider limitWordProvider
     */
    public function testLimitWordReturnsExpected($to, $from, $ending, $limit)
    {
        $this->textTruncator->setEnding($ending);
        $this->textTruncator->setLimit($limit);
        $limited = $this->textTruncator->limitWords($from);
        $this->assertInternalType('string', $limited);
        $this->assertEquals($to, $limited);
    }
}
