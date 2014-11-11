<?php
namespace Orukusaki\TwilioBundle\Payload;

class CallStatus extends VoiceCall
{
    /**
     * The duration in seconds of the just-completed call.
     *
     * @var string
     */
    public $callDuration;

    /**
     * The URL of the phone call's recorded audio. This parameter is included only if Record=true is set on the REST API request, and does not include recordings from <Dial> or <Record>.
     *
     * @var string
     */
    public $recordingUrl;

    /**
     * The unique id of the Recording from this call.
     *
     * @var string
     */
    public $recordingSid;

    /**
     * The duration of the recorded audio (in seconds).
     *
     * @var string
     */
    public $recordingDuration;
}
