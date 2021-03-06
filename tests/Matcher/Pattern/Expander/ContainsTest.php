<?php

declare(strict_types=1);

namespace Coduo\PHPMatcher\Tests\Matcher\Pattern\Expander;

use Coduo\PHPMatcher\Matcher\Pattern\Expander\Contains;
use PHPUnit\Framework\TestCase;

class ContainsTest extends TestCase
{
    /**
     * @dataProvider examplesIgnoreCaseProvider
     */
    public function test_matching_values_ignore_case($needle, $haystack, $expectedResult)
    {
        $expander = new Contains($needle);
        $this->assertEquals($expectedResult, $expander->match($haystack));
    }

    public static function examplesIgnoreCaseProvider()
    {
        return [
            ["ipsum", "lorem ipsum", true],
            ["wor", "this is my hello world string", true],
            ["lol", "lorem ipsum", false],
            ["NO", "norbert", false]
        ];
    }

    /**
     * @dataProvider examplesProvider
     */
    public function test_matching_values($needle, $haystack, $expectedResult)
    {
        $expander = new Contains($needle, true);
        $this->assertEquals($expectedResult, $expander->match($haystack));
    }

    public static function examplesProvider()
    {
        return [
            ["IpSum", "lorem ipsum", true],
            ["wor", "this is my hello WORLD string", true],
            ["lol", "LOREM ipsum", false],
            ["NO", "NORBERT", true]
        ];
    }

    /**
     * @dataProvider invalidCasesProvider
     */
    public function test_error_when_matching_fail($string, $value, $errorMessage)
    {
        $expander = new Contains($string);
        $this->assertFalse($expander->match($value));
        $this->assertEquals($errorMessage, $expander->getError());
    }

    public static function invalidCasesProvider()
    {
        return [
            ["ipsum", "hello world", "String \"hello world\" doesn't contains \"ipsum\"."],
            ["lorem", new \DateTime(), "Contains expander require \"string\", got \"\\DateTime\"."],
        ];
    }
}
