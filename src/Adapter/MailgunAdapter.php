<?php
declare(strict_types = 1);

namespace Zortje\Emailer\Adapter;

use Mailgun\Mailgun;
use Zortje\Emailer\Email;

/**
 * Class MailgunAdapter
 *
 * @package Zortje\Emailer\Adapter
 */
class MailgunAdapter implements ServiceAdapter
{

    /**
     * @var Mailgun
     */
    protected $mailgun;

    /**
     * @var string
     */
    protected $domain;

    /**
     * MailgunAdapter constructor.
     *
     * @param Mailgun $mailgun
     * @param string  $domain
     */
    public function __construct(Mailgun $mailgun, string $domain)
    {
        $this->mailgun = $mailgun;
        $this->domain  = $domain;
    }

    /**
     * @inheritdoc
     */
    public function send(Email $email)
    {
        $this->mailgun->sendMessage($this->domain, $this->getMessage($email));
    }

    /**
     * Get message from email to be used by Mailgun API wrapper
     *
     * @param Email $email
     *
     * @return array
     */
    protected function getMessage(Email $email): array
    {
        $from = $this->formatFrom($email);
        $to   = $this->formatToType('to', $email);

        if (empty($to)) {
            throw new \InvalidArgumentException('An email must have at least a single recipient');
        }

        $message = [
            'from'    => $from,
            'to'      => $to,
            'subject' => $email->getSubject()
        ];

        /**
         * HTML and text content
         */
        $html = $email->getHtml();
        $text = $email->getText();

        if (empty($html) && empty($text)) {
            throw new \InvalidArgumentException('A message body in HTML or text is missing');
        }

        if (!empty($html)) {
            $message['html'] = $html;
        }

        if (!empty($text)) {
            $message['text'] = $text;
        }

        /**
         * CC
         */
        $cc = $this->formatToType('cc', $email);

        if (!empty($cc)) {
            $message['cc'] = $cc;
        }

        /**
         * BCC
         */
        $bcc = $this->formatToType('bcc', $email);

        if (!empty($bcc)) {
            $message['bcc'] = $bcc;
        }

        /**
         * Headers
         */
        foreach ($email->getHeaders() as $header => $value) {
            $message["h:$header"] = $value;
        }

        /**
         * Tag
         */
        $tag = $email->getTag();

        if (!empty($tag)) {
            $message['o:tag'] = $tag;
        }

        // @todo Handle campaign ('o:campaign')

        // @todo Handle attachment ('attachment')
        // @todo Handle inline ('o:inline')

        var_dump($message);

        return $message;
    }

    /**
     * Format 'from' to be used by the Mailgun API wrapper
     *
     * @param Email $email
     *
     * @return string Formatted 'from' string, Example: 'Bob <bob@host.com>'
     */
    protected function formatFrom(Email $email): string
    {
        $from = $email->getFrom();

        if (empty($from['name']) || empty($from['email'])) {
            throw new \InvalidArgumentException('From parameter is missing');
        }

        return "{$from['name']} <{$from['email']}>";
    }

    /**
     * Format 'to' types to be used by the Mailgun API wrapper
     *
     * @param string $type To type: 'to', 'cc' or 'bcc'
     * @param Email  $email
     *
     * @return string Formatted 'to' of type string, Example: 'Bob <bob@host.com>' (separated by commas for multiple recipients)
     */
    protected function formatToType(string $type, Email $email): string
    {
        $tos = [];

        foreach ($email->getTo() as $to) {
            if ($to['type'] === $type) {
                $tos[] = "{$to['name']} <{$to['email']}>";
            }
        }

        return implode(', ', $tos);
    }
}
