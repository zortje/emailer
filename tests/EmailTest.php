<?php
declare(strict_types = 1);

namespace Zortje\Emailer\Tests;

use Faker\Factory;
use Zortje\Emailer\Email;

/**
 * Class EmailTest
 *
 * @package            Zortje\Emailer\Tests
 *
 * @coversDefaultClass Zortje\Emailer\Email
 */
class EmailTest extends \PHPUnit_Framework_TestCase
{

    private $faker;

    public function setUp()
    {
        $this->faker = Factory::create();
    }

    /**
     * @covers ::setFrom
     * @covers ::getFrom
     */
    public function testSetFrom()
    {
        $email = new Email();

        $name         = $this->faker->name;
        $emailAddress = $this->faker->email;

        $email->setFrom($name, $emailAddress);

        $reflector = new \ReflectionClass($email);

        $fromProperty = $reflector->getProperty('from');
        $fromProperty->setAccessible(true);

        $expected = [
            'name'  => $name,
            'email' => $emailAddress
        ];

        $this->assertSame($expected, $fromProperty->getValue($email));
        $this->assertSame($expected, $email->getFrom());
    }

    /**
     * @covers ::setFrom
     */
    public function testSetFromEmptyName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('From name must be provided');

        $email = new Email();
        $email->setFrom('', $this->faker->email);
    }

    /**
     * @covers ::setFrom
     */
    public function testSetFromInvalidEmail()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Email \'invalid[at]example.com\' is invalid');

        $email = new Email();
        $email->setFrom($this->faker->name, 'invalid[at]example.com');
    }

    /**
     * @covers ::setTo
     * @covers ::getTo
     */
    public function testSetTo()
    {
        $email = new Email();

        $expected = [
            [
                'type'  => 'to',
                'name'  => $this->faker->name,
                'email' => $this->faker->email
            ],
            [
                'type'  => 'cc',
                'name'  => $this->faker->name,
                'email' => $this->faker->email
            ],
            [
                'type'  => 'bcc',
                'name'  => $this->faker->name,
                'email' => $this->faker->email
            ]
        ];

        $email->setTo('to', $expected[0]['name'], $expected[0]['email']);
        $email->setTo('cc', $expected[1]['name'], $expected[1]['email']);
        $email->setTo('bcc', $expected[2]['name'], $expected[2]['email']);

        $reflector = new \ReflectionClass($email);

        $toProperty = $reflector->getProperty('to');
        $toProperty->setAccessible(true);

        $this->assertSame($expected, $toProperty->getValue($email));
        $this->assertSame($expected, $email->getTo());
    }

    /**
     * @covers ::setTo
     */
    public function testSetToInvalidType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Type \'foo\' is not allowed, must be either \'to\', \'cc\' or \'bcc\'');

        $email = new Email();
        $email->setTo('foo', $this->faker->name, $this->faker->email);
    }

    /**
     * @covers ::setTo
     */
    public function testSetToEmptyName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('To name must be provided');

        $email = new Email();
        $email->setTo('to', '', $this->faker->email);
    }

    /**
     * @covers ::setTo
     */
    public function testSetToInvalidEmail()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Email \'invalid[at]example.com\' is invalid');

        $email = new Email();
        $email->setTo('to', $this->faker->name, 'invalid[at]example.com');
    }

    /**
     * @covers ::setSubject
     * @covers ::getSubject
     */
    public function testSetSubject()
    {
        $email = new Email();

        $subject = $this->faker->sentence;

        $email->setSubject($subject);

        $reflector = new \ReflectionClass($email);

        $subjectProperty = $reflector->getProperty('subject');
        $subjectProperty->setAccessible(true);

        $this->assertSame($subject, $subjectProperty->getValue($email));
        $this->assertSame($subject, $email->getSubject());
    }

    /**
     * @covers ::setHeader
     * @covers ::getHeaders
     */
    public function testSetHeaders() {

        // @todo
        $this->markTestIncomplete();

    }

    /**
     * @covers ::setHtml
     * @covers ::getHtml
     */
    public function testSetHtml()
    {
        $email = new Email();

        $html = $this->faker->text;

        $email->setHtml($html);

        $reflector = new \ReflectionClass($email);

        $htmlProperty = $reflector->getProperty('html');
        $htmlProperty->setAccessible(true);

        $this->assertSame($html, $htmlProperty->getValue($email));
        $this->assertSame($html, $email->getHtml());
    }

    /**
     * @covers ::setText
     * @covers ::getText
     */
    public function testSetText()
    {
        $email = new Email();

        $text = $this->faker->text;

        $email->setText($text);

        $reflector = new \ReflectionClass($email);

        $textProperty = $reflector->getProperty('text');
        $textProperty->setAccessible(true);

        $this->assertSame($text, $textProperty->getValue($email));
        $this->assertSame($text, $email->getText());
    }

    /**
     * @covers ::setTag
     * @covers ::getTag
     */
    public function testSetTag()
    {
        $email = new Email();

        $tag = $this->faker->text;

        $email->setTag($tag);

        $reflector = new \ReflectionClass($email);

        $tagProperty = $reflector->getProperty('tag');
        $tagProperty->setAccessible(true);

        $this->assertSame($tag, $tagProperty->getValue($email));
        $this->assertSame($tag, $email->getTag());
    }
}
