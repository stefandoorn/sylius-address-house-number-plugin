<?php

declare(strict_types=1);

namespace Tests\StefanDoorn\SyliusStreetNumberPlugin\Behat\Context\Ui\Shop\Checkout;

use Behat\Behat\Context\Context;
use StefanDoorn\SyliusStreetNumberPlugin\Entity\Interfaces\AddressInterface;
use Sylius\Behat\Page\Shop\Checkout\SelectShippingPageInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Addressing\Comparator\AddressComparatorInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Tests\StefanDoorn\SyliusStreetNumberPlugin\Behat\Page\Shop\Checkout\AddressPageInterface;
use Webmozart\Assert\Assert;

final class CheckoutAddressingContext implements Context
{
    /** @var SharedStorageInterface */
    private $sharedStorage;

    /** @var AddressPageInterface */
    private $addressPage;

    /** @var FactoryInterface */
    private $addressFactory;

    /** @var AddressComparatorInterface */
    private $addressComparator;

    /** @var SelectShippingPageInterface */
    private $selectShippingPage;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        AddressPageInterface $addressPage,
        FactoryInterface $addressFactory,
        AddressComparatorInterface $addressComparator,
        SelectShippingPageInterface $selectShippingPage
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->addressPage = $addressPage;
        $this->addressFactory = $addressFactory;
        $this->addressComparator = $addressComparator;
        $this->selectShippingPage = $selectShippingPage;
    }

    /**
     * @When /^I specify the shipping (address extended as "[^"]+", "[^"]+", "[^"]+", "[^"]+", "[^"]+", "[^"]+" for "[^"]+")$/
     */
    public function iSpecifyTheShippingAddressAs(AddressInterface $address)
    {
        $key = sprintf(
            'shipping_address_%s_%s',
            strtolower((string) $address->getFirstName()),
            strtolower((string) $address->getLastName())
        );
        $this->sharedStorage->set($key, $address);

        $this->addressPage->specifyShippingAddress($address);
    }

    /**
     * @When /^I specify the billing (address extended as "[^"]+", "[^"]+", "[^"]+", "[^"]+", "[^"]+", "[^"]+" for "[^"]+")$/
     */
    public function iSpecifyTheBillingAddressAs(AddressInterface $address)
    {
        $key = sprintf(
            'billing_address_%s_%s',
            strtolower((string) $address->getFirstName()),
            strtolower((string) $address->getLastName())
        );
        $this->sharedStorage->set($key, $address);

        $this->addressPage->specifyBillingAddress($address);
    }

    /**
     * @Then /^I should be notified that the street number in (shipping|billing) details is required$/
     */
    public function iShouldBeNotifiedThatTheStreetNumberShippingDetailsIsRequired($type): void
    {
        $element = 'number';

        $this->assertElementValidationMessage($type, $element, sprintf('Please fill in a street %s.', $element));
    }

    /**
     * @Then /^I should not be notified that the street number addition in (shipping|billing) details is required$/
     */
    public function iShouldNotBeNotifiedThatTheStreetNumberAdditionShippingDetailsIsRequired($type): void
    {
        $element = 'addition';

        $this->assertElementHasNoValidationMessage($type, $element);
    }

    /**
     * @Then /^(address "[^"]+", "[^"]+", "[^"]+", "[^"]+", "[^"]+") should be filled as shipping address$/
     */
    public function addressShouldBeFilledAsShippingAddress(AddressInterface $address)
    {
        Assert::true($this->addressComparator->equal($address, $this->addressPage->getPreFilledShippingAddress()));
    }

    /**
     * @Then /^(address "[^"]+", "[^"]+", "[^"]+", "[^"]+", "[^"]+") should be filled as billing address$/
     */
    public function addressShouldBeFilledAsBillingAddress(AddressInterface $address)
    {
        Assert::true($this->addressComparator->equal($address, $this->addressPage->getPreFilledBillingAddress()));
    }

    private function assertElementValidationMessage(string $type, string $element, string $expectedMessage): void
    {
        $element = sprintf('%s_%s', $type, str_replace(' ', '_', $element));
        Assert::true($this->addressPage->checkValidationMessageFor($element, $expectedMessage));
    }

    private function assertElementHasNoValidationMessage(string $type, string $element): void
    {
        $element = sprintf('%s_%s', $type, str_replace(' ', '_', $element));
        Assert::true($this->addressPage->noValidationMessageFor($element));
    }
}
