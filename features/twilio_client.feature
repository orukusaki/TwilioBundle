Feature: Twilio Client added to service container
  As an app developer
  I want to have the Twilio client in the service container
  So I can use it to access the Twilio API

  Scenario: Correctly configured app includes twilio service
    Given an app config with:
    """
    orukusaki_twilio:
      client:
        account_id: 1234546
        token: ABCD1234
    """
    When the app is booted
    Then there should be a twilio client available in the service container

  Scenario: Without Twilio config, no client is added to the container
    Given I have not added twilio config
    When the app is booted
    Then there should not be a twilio client available in the service container
