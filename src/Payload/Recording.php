<?php
namespace Orukusaki\TwilioBundle\Payload;

class Recording
{
    use VoiceCall;

    /**
     * The URL of the recorded audio
     */
    public $recordingUrl;

    /**
     * the duration of the recorded audio (in seconds)
     */
    public $recordingDuration;

    /**
     * The key (if any) pressed to end the recording or 'hangup' if the caller hung up
     */
    public $digits;
}
