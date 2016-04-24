<?php
declare(strict_types = 1);

namespace Zortje\Emailer\Tests;

use Zortje\Emailer\Adapter\MailgunAdapter;
use Zortje\Emailer\Mailer;

/**
 * Class MailerTest
 *
 * @package            Zortje\Emailer\Tests
 *
 * @coversDefaultClass Zortje\Emailer\Mailer
 */
class MailerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
        /**
         * @var MailgunAdapter $mailgunAdapter
         */
        $mailgunAdapter = $this->getMockBuilder('Zortje\Emailer\Adapter\MailgunAdapter')->disableOriginalConstructor()->getMock();

        $mailer = new Mailer($mailgunAdapter);

        $reflector = new \ReflectionClass($mailer);

        $serviceAdapterProperty = $reflector->getProperty('serviceAdapter');
        $serviceAdapterProperty->setAccessible(true);

        $this->assertSame($mailgunAdapter, $serviceAdapterProperty->getValue($mailer));
    }

    // @todo test ::send

}
