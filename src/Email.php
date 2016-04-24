<?php
declare(strict_types = 1);

namespace Zortje\Emailer;

/**
 * Class Email
 *
 * @package Zortje\Emailer
 */
class Email
{

    /**
     * @var array
     */
    protected $from = [];

    /**
     * @var array
     */
    protected $to = [];

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var string
     */
    protected $text = '';

    /**
     * @var string
     */
    protected $html = '';

    /**
     * @var string
     */
    protected $tag;

    /**
     * Set 'from' with name and email
     *
     * @param string $name  Name
     * @param string $email Email address
     */
    public function setFrom(string $name, string $email)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('From name must be provided');
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new \InvalidArgumentException("Email '$email' is invalid");
        }

        $this->from = [
            'name'  => $name,
            'email' => $email
        ];
    }

    /**
     * Get 'from' array with name and email
     *
     * @return array
     */
    public function getFrom(): array
    {
        return $this->from;
    }

    /**
     * Set 'to' with name and email for 'to', 'cc' or 'bcc'
     *
     * @param string $type  To type: 'to', 'cc' or 'bcc'
     * @param string $name  Name
     * @param string $email Email address
     */
    public function setTo(string $type, string $name, string $email)
    {
        if ($type !== 'to' && $type !== 'cc' && $type !== 'bcc') {
            throw new \InvalidArgumentException("Type '$type' is not allowed, must be either 'to', 'cc' or 'bcc'");
        }

        if (empty($name)) {
            throw new \InvalidArgumentException('To name must be provided');
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new \InvalidArgumentException("Email '$email' is invalid");
        }

        $this->to[] = [
            'type'  => $type,
            'name'  => $name,
            'email' => $email
        ];
    }

    /**
     * Get 'to' array with type, name and email
     *
     * @return array
     */
    public function getTo(): array
    {
        return $this->to;
    }

    /**
     * Set message subject
     *
     * @param string $subject Message subject
     */
    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    /**
     * Get message subject
     *
     * @return string Message subject
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * Set message header
     *
     * @param string $header Header name
     * @param string $value  Header value
     */
    public function setHeader(string $header, string $value)
    {
        $this->headers[$header] = $value;
    }

    /**
     * Get message headers
     *
     * @return array Message headers
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Set message body HTML version
     *
     * @param string $html Message body HTML version
     */
    public function setHtml(string $html)
    {
        $this->html = $html;
    }

    /**
     * Get message body HTML version
     *
     * @return string Message body HTML version
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * Set message body text version
     *
     * @param string $text Message body text version
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

    /**
     * Get message body text version
     *
     * @return string Message body text version
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Set message tag
     *
     * @param string $tag Message tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * Get message tag
     *
     * @return string Message tag
     */
    public function getTag()
    {
        return $this->tag;
    }
}
