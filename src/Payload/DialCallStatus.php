<?php

namespace Orukusaki\TwilioBundle\Payload;

class DialCallStatus extends VoiceCall
{
    /**
     * The outcome of the <Dial> attempt. See the DialCallStatus section below for details.
     */
    public $dialCallStatus;

    /**
     * The call sid of the new call leg. This parameter is not sent after dialing a conference.
     */
    public $dialCallSid;

    /**
     * The duration in seconds of the dialed call. This parameter is not sent after dialing a conference.
     */
    public $dialCallDuration;

    /**
     * The URL of the recorded audio. This parameter is only sent if a recording is used with the <Dial> verb,
     * and does not include recordings from the <Record> verb, Record=True on REST API calls, or <Conference> record.
     */
    public $recordingUrl;

    public function isSuccessfulResult()
    {
        return $this->dialCallStatus == 'completed';
    }
} 
