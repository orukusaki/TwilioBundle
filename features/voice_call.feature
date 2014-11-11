Feature: Voice call is received and processed
  As a bundle user
  I want to be able to listen to voice call events
  So I can process the call

  Scenario: Call received
    Given I have registered an incoming call listener
    When an inbound call is received with the params:
      | Param         | Value        |
      | CallSid       | abc1         |
      | AccountSid    | 12345        |
      | From          | +44000000001 |
      | To            | +44000000002 |
      | CallStatus    | ringing      |
      | ApiVersion    | 2.5          |
      | Direction     | inbound      |
      | ForwardedFrom |              |
      | CallerName    | Barry        |
    Then the listener should be called
    And the payload should be an inbound call
    And the payload should have fields:
      | Var           | Value        |
      | callSid       | abc1         |
      | accountSid    | 12345        |
      | from          | +44000000001 |
      | to            | +44000000002 |
      | callStatus    | ringing      |
      | apiVersion    | 2.5          |
      | direction     | inbound      |
      | forwardedFrom |              |
      | callerName    | Barry        |
