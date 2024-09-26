@house_number_checkout
Feature: Addressing an order
    In order to address an order
    As a Guest
    I want to be able to fill extended addressing details

    Background:
        Given the store operates on a single channel in "United States"
        And the store ships everywhere for free
        And the store has a product "PHP T-Shirt" priced at "$19.99"

    @ui
    Scenario: Address an order without different billing address
        Given I have product "PHP T-Shirt" in the cart
        And I am at the checkout addressing step
        When I specify the email as "jon.snow@example.com"
        And I specify the shipping address extended as "Ankh Morpork", "Frost Alley", "12", "a", "90210", "United States" for "Jon Snow"
        And I complete the addressing step
        Then I should be on the checkout shipping step

    @ui
    Scenario: Address an order without different billing address with optional addition
        Given I have product "PHP T-Shirt" in the cart
        And I am at the checkout addressing step
        When I specify the email as "jon.snow@example.com"
        And I specify the shipping address extended as "Ankh Morpork", "Frost Alley", "12", "", "90210", "United States" for "Jon Snow"
        And I complete the addressing step
        Then I should be on the checkout shipping step

    @ui
    Scenario: Address an order with different billing address with optional addition
        Given I have product "PHP T-Shirt" in the cart
        And I am at the checkout addressing step
        When I specify the email as "eddard.stark@example.com"
        And I specify the shipping address extended as "Ankh Morpork", "Frost Alley", "12", "", "90210", "United States" for "Jon Snow"
        And I specify the billing address extended as "Ankh Morpork", "Frost Alley", "14", "", "90210", "United States" for "Eddard Stark"
        And I complete the addressing step
        Then I should be on the checkout shipping step
