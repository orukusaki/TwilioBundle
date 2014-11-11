<?php
namespace Orukusaki\TwilioBundle\Payload;

/**
 * Class VoiceCall
 * @package Orukusaki\TwilioBundle\Payload
 */
class VoiceCall
{
    /**
     * A unique identifier for this call, generated by Twilio.
     *
     * @var string
     */
    public $callSid;

    /**
     * Your Twilio account id. It is 34 characters long, and always starts with the letters AC.
     *
     * @var string
     */
    public $accountSid;

    /**
     * The phone number or client identifier of the party that initiated the call.
     * Phone numbers are formatted with a '+' and country code, e.g. +16175551212 (E.164 format).
     * Client identifiers begin with the client: URI scheme; for example, for a call from a client named 'tommy',
     * the From parameter will be client:tommy.
     *
     * @var string
     */
    public $from;

    /**
     * The phone number or client identifier of the called party.
     * Phone numbers are formatted with a '+' and country code, e.g. +16175551212 (E.164 format).
     * Client identifiers begin with the client: URI scheme; for example, for a call to a client named 'jenny',
     * the To parameter will be client:jenny.
     *
     * @var string
     */
    public $to;

    /**
     * A descriptive status for the call. The value is one of queued, ringing, in-progress, completed,
     * busy, failed or no-answer. See the CallStatus section below for more details.
     *
     * @var string
     */
    public $callStatus;

    /**
     * The version of the Twilio API used to handle this call.
     * For incoming calls, this is determined by the API version set on the called number.
     * For outgoing calls, this is the API version used by the outgoing call's REST API request.
     *
     * @var string
     */
    public $apiVersion;

    /**
     * A string describing the direction of the call.
     * inbound for inbound calls, outbound-api for calls initiated via the REST API or outbound-dial
     * for calls initiated by a <Dial> verb.
     *
     * @var string
     */
    public $direction;

    /**
     * This parameter is set only when Twilio receives a forwarded call, but its value depends on the
     * caller's carrier including information when forwarding. Not all carriers support passing this information.
     *
     * @var string
     */
    public $forwardedFrom;

    /**
     * This parameter is set when the IncomingPhoneNumber that received the call has had its VoiceCallerIdLookup
     * value set to true ($0.01 per look up).
     *
     * @var string
     */
    public $callerName;

    /**
     * The city of the caller.
     *
     * @var string
     */
    public $fromCity;

    /**
     * The state or province of the caller.
     *
     * @var string
     */
    public $fromState;

    /**
     * The postal code of the caller.
     *
     * @var string
     */
    public $fromZip;

    /**
     * The country of the caller.
     *
     * @var string
     */
    public $fromCountry;

    /**
     * The city of the called party.
     *
     * @var string
     */
    public $toCity;

    /**
     * The state or province of the called party.
     *
     * @var string
     */
    public $toState;

    /**
     * The postal code of the called party.
     *
     * @var string
     */
    public $toZip;

    /**
     * The country of the called party.
     *
     * @var string
     */
    public $toCountry;
}
