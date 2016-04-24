<?php
declare(strict_types = 1);

namespace Zortje\Emailer\Tests\Adapter;

use Faker\Factory;
use Mailgun\Mailgun;
use Zortje\Emailer\Adapter\MailgunAdapter;
use Zortje\Emailer\Email;

/**
 * Class MailgunAdapterTest
 *
 * @package            Zortje\Emailer\Tests\Adapter
 *
 * @coversDefaultClass Zortje\Emailer\Adapter\MailgunAdapter
 */
class MailgunAdapterTest extends \PHPUnit_Framework_TestCase
{

    private $faker;

    public function setUp()
    {
        $this->faker = Factory::create();
    }

    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        /**
         * @var Mailgun $mailgun
         */
        $mailgun = $this->getMockBuilder('Mailgun\Mailgun')->getMock();
        $domain = 'example.com';

        $mailgunAdapter = new MailgunAdapter($mailgun, $domain);

        $reflector = new \ReflectionClass($mailgunAdapter);

        $mailgunProperty = $reflector->getProperty('mailgun');
        $mailgunProperty->setAccessible(true);

        $domainProperty = $reflector->getProperty('domain');
        $domainProperty->setAccessible(true);

        $this->assertSame($mailgun, $mailgunProperty->getValue($mailgunAdapter));
        $this->assertSame($domain, $domainProperty->getValue($mailgunAdapter));
    }

    // @todo test ::send

    // @todo test ::getMessage

    /**
     * @covers ::formatFrom
     */
    public function testFormatFrom()
    {
        /**
         * @var Mailgun $mailgun
         */
        $mailgun = $this->getMockBuilder('Mailgun\Mailgun')->getMock();

        $mailgunAdapter = new MailgunAdapter($mailgun, '');

        $reflector = new \ReflectionClass($mailgunAdapter);

        $method = $reflector->getMethod('formatFrom');
        $method->setAccessible(true);

        $name         = $this->faker->name;
        $emailAddress = $this->faker->email;

        $email = new Email();
        $email->setFrom($name, $emailAddress);

        $this->assertSame("$name <$emailAddress>", $method->invoke($mailgunAdapter, $email));
    }

    /**
     * @covers ::formatFrom
     */
    public function testFormatFromEmpty()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('From parameter is missing');

        /**
         * @var Mailgun $mailgun
         */
        $mailgun = $this->getMockBuilder('Mailgun\Mailgun')->getMock();

        $mailgunAdapter = new MailgunAdapter($mailgun, '');

        $reflector = new \ReflectionClass($mailgunAdapter);

        $method = $reflector->getMethod('formatFrom');
        $method->setAccessible(true);

        $email = new Email();

        $method->invoke($mailgunAdapter, $email);
    }

    /**
     * @covers ::formatToType
     */
    public function testFormatToTypeSingle()
    {
        /**
         * @var Mailgun $mailgun
         */
        $mailgun = $this->getMockBuilder('Mailgun\Mailgun')->getMock();

        $mailgunAdapter = new MailgunAdapter($mailgun, '');

        $reflector = new \ReflectionClass($mailgunAdapter);

        $method = $reflector->getMethod('formatToType');
        $method->setAccessible(true);

        $name         = $this->faker->name;
        $emailAddress = $this->faker->email;

        $email = new Email();
        $email->setTo('to', $name, $emailAddress);
        $email->setTo('cc', $this->faker->name, $this->faker->email);
        $email->setTo('bcc', $this->faker->name, $this->faker->email);

        $this->assertSame("$name <$emailAddress>", $method->invoke($mailgunAdapter, 'to', $email));
    }

    /**
     * @covers ::formatToType
     */
    public function testFormatToTypeMultiple()
    {
        /**
         * @var Mailgun $mailgun
         */
        $mailgun = $this->getMockBuilder('Mailgun\Mailgun')->getMock();

        $mailgunAdapter = new MailgunAdapter($mailgun, '');

        $reflector = new \ReflectionClass($mailgunAdapter);

        $method = $reflector->getMethod('formatToType');
        $method->setAccessible(true);

        $names          = [$this->faker->name, $this->faker->name];
        $emailAddresses = [$this->faker->email, $this->faker->email];

        $email = new Email();
        $email->setTo('to', $names[0], $emailAddresses[0]);
        $email->setTo('to', $names[1], $emailAddresses[1]);

        $expected = "$names[0] <$emailAddresses[0]>, $names[1] <$emailAddresses[1]>";

        $this->assertSame($expected, $method->invoke($mailgunAdapter, 'to', $email));
    }

    /**
     * @covers ::formatToType
     */
    public function testFormatToTypeEmpty()
    {
        /**
         * @var Mailgun $mailgun
         */
        $mailgun = $this->getMockBuilder('Mailgun\Mailgun')->getMock();

        $mailgunAdapter = new MailgunAdapter($mailgun, '');

        $reflector = new \ReflectionClass($mailgunAdapter);

        $method = $reflector->getMethod('formatToType');
        $method->setAccessible(true);

        $email = new Email();

        $this->assertSame('', $method->invoke($mailgunAdapter, 'to', $email));
    }
}
