<?php
namespace Orukusaki\TwilioBundle\Payload;

/**
 * Class SmsReceivedEvent
 */
class Sms
{
    /**
     * A 34 character unique identifier for the message. May be used to later retrieve this message from the REST API.
     *
     * @var string
     */
    public $messageSid;

    /**
     * Same value as MessageSid. Deprecated and included for backward compatibility.
     *
     * @var string
     */
    public $smsSid;

    /**
     * The 34 character id of the Account this message is associated with.
     *
     * @var string
     */
    public $accountSid;

    /**
     * The phone number that sent this message.
     *
     * @var string
     */
    public $from;

    /**
     * The phone number of the recipient.
     *
     * @var string
     */
    public $to;

    /**
     * The text body of the message. Up to 1600 characters long.
     *
     * @var string
     */
    public $body;

    /**
     * The number of media items associated with your message
     *
     * @var string
     */
    public $numMedia;

    /**
     * The ContentTypes for the Media stored at MediaUrl{N}. The order of MediaContentType{N} matches the order of
     * MediaUrl{N}. If more than one media element is indicated by NumMedia than MediaContentType{N} will be used,
     * where N is the count of the Media
     *
     * @var string[]
     */
    public $mediaContentType;

    /**
     * A URL referencing the content of the media received in the Message. If more than one media element is indicated
     * by NumMedia than MediaUrl{N} will be used, where N is the count of the Media
     *
     * @var string[]
     */
    public $mediaUrl;

    /**
     * The city of the sender
     *
     * @var string
     */
    public $fromCity;

    /**
     * The state or province of the sender.
     *
     * @var string
     */
    public $fromState;

    /**
     * The postal code of the called sender.
     *
     * @var string
     */
    public $fromZip;

    /**
     * The country of the called sender.
     *
     * @var string
     */
    public $fromCountry;

    /**
     * The city of the recipient.
     *
     * @var string
     */
    public $toCity;

    /**
     * The state or province of the recipient.
     *
     * @var string
     */
    public $toState;

    /**
     * The postal code of the recipient.
     *
     * @var string
     */
    public $toZip;

    /**
     * The country of the recipient.
     *
     * @var string
     */
    public $toCountry;
}
