@house_number_address_book
Feature: Seeing validation messages during address addition
    In order to be sure that the address I'm trying to add is correct
    As a Customer
    I want to be prevented from adding invalid addresses

    Background:
        Given the store operates on a single channel in "United States"
        And I am a logged in customer

    @ui @javascript
    Scenario: The street number needs to be entered
        When I want to add a new address to my address book
        And I specify the address as "Lucifer Morningstar", "Seaside Fwy", "90802", "Los Angeles", "United States", "Arkansas"
        And I add it
        Then I should still be on the address addition page
        Then I should be notified that the street number is required
