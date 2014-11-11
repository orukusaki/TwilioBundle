Feature: Call status is received and processed
  As a bundle user
  I want to be able to listen to call status events
  So I can process the call

  Scenario: Status received
    Given I have registered a call status listener
    When a call status is received with the params:
      | Param                 | Value        |
      | CallSid               | abc1         |
      | AccountSid            | 12345        |
      | From                  | +44000000001 |
      | To                    | +44000000002 |
      | CallStatus            | ringing      |
      | ApiVersion            | 2.5          |
      | Direction             | inbound      |
      | ForwardedFrom         |              |
      | CallerName            | Barry        |
      | CallDuration          | 14           |
      | RecordingUrl          | http://url   |
      | RecordingSid          | 12341234     |
      | RecordingDuration     | 10           |
    Then the listener should be called
    And the payload should be a call status
    And the payload should have fields:
      | Var                   | Value        |
      | callSid               | abc1         |
      | accountSid            | 12345        |
      | from                  | +44000000001 |
      | to                    | +44000000002 |
      | callStatus            | ringing      |
      | apiVersion            | 2.5          |
      | direction             | inbound      |
      | forwardedFrom         |              |
      | callerName            | Barry        |
      | callDuration          | 14           |
      | recordingUrl          | http://url   |
      | recordingSid          | 12341234     |
      | recordingDuration     | 10           |
