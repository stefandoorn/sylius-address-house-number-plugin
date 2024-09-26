<?php

declare(strict_types=1);

namespace Tests\StefanDoorn\SyliusStreetNumberPlugin\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Component\Addressing\Converter\CountryNameConverterInterface;
use Sylius\Component\Core\Repository\AddressRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class AddressContext implements Context
{
    /** @var FactoryInterface */
    private $addressFactory;

    /** @var CountryNameConverterInterface */
    private $countryNameConverter;

    /** @var AddressRepositoryInterface */
    private $addressRepository;

    /** @var ExampleFactoryInterface */
    private $exampleAddressFactory;

    public function __construct(
        FactoryInterface $addressFactory,
        CountryNameConverterInterface $countryNameConverter,
        AddressRepositoryInterface $addressRepository,
        ExampleFactoryInterface $exampleAddressFactory
    ) {
        $this->addressFactory = $addressFactory;
        $this->countryNameConverter = $countryNameConverter;
        $this->addressRepository = $addressRepository;
        $this->exampleAddressFactory = $exampleAddressFactory;
    }

    /**
     * @Transform /^address (?:as |is |to )"([^"]+)", "([^"]+)", "([^"]+)", "([^"]+)" for "([^"]+)"$/
     */
    public function createNewAddressWith($city, $street, $postcode, $countryName, $customerName)
    {
        [$firstName, $lastName] = explode(' ', $customerName);

        $exp = explode(' ', $street);
        $addition = array_pop($exp);
        $number = array_pop($exp);
        $street = implode(' ', $exp);

        return $this->exampleAddressFactory->create([
            'country_code' => $this->countryNameConverter->convertToCode($countryName),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'company' => null,
            'customer' => null,
            'phone_number' => null,
            'city' => $city,
            'street' => $street,
            'postcode' => $postcode,
            'number' => $number,
            'addition' => $addition,
        ]);
    }

    /**
     * @Transform /^address extended (?:as |is |to )"([^"]+)", ([^"]+)", ([^"]+)", "([^"]+)", "([^"]+)", "([^"]+)" for "([^"]+)"$/
     */
    public function createNewExtendedAddressWith($city, $street, $number, $addition, $postcode, $countryName, $customerName)
    {
        [$firstName, $lastName] = explode(' ', $customerName);

        return $this->exampleAddressFactory->create([
            'country_code' => $this->countryNameConverter->convertToCode($countryName),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'company' => null,
            'customer' => null,
            'phone_number' => null,
            'city' => $city,
            'street' => $street,
            'postcode' => $postcode,
            'number' => $number,
            'addition' => $addition,
        ]);
    }

    /**
     * @Transform /^clear old (shipping|billing) address$/
     * @Transform /^do not specify any (shipping|billing) address$/
     */
    public function createEmptyAddress()
    {
        return $this->addressFactory->createNew();
    }

    /**
     * @Transform /^address for "([^"]+)" from "([^"]+)", "([^"]+)", "([^"]+)", "([^"]+)", "([^"]+)"$/
     * @Transform /^"([^"]+)" addressed it to "([^"]+)", "([^"]+)" "([^"]+)" in the "([^"]+)", "([^"]+)"$/
     * @Transform /^of "([^"]+)" in the "([^"]+)", "([^"]+)" "([^"]+)", "([^"]+)", "([^"]+)"$/
     * @Transform /^addressed it to "([^"]+)", "([^"]+)", "([^"]+)" "([^"]+)" in the "([^"]+)", "([^"]+)"$/
     * @Transform /^address (?:|is |as )"([^"]+)", "([^"]+)", "([^"]+)", "([^"]+)", "([^"]+)", "([^"]+)"$/
     */
    public function createNewAddressWithNameAndProvince($name, $street, $postcode, $city, $countryName, $provinceName)
    {
        [$firstName, $lastName] = explode(' ', $name);

        $exp = explode(' ', $street);
        $addition = array_pop($exp);
        $number = array_pop($exp);
        $street = implode(' ', $exp);

        return $this->exampleAddressFactory->create([
            'country_code' => $this->countryNameConverter->convertToCode($countryName),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'company' => null,
            'customer' => null,
            'phone_number' => null,
            'city' => $city,
            'street' => $street,
            'postcode' => $postcode,
            'province_name' => $provinceName,
            'number' => $number,
            'addition' => $addition,
        ]);
    }

    /**
     * @Transform /^"([^"]+)" addressed it to "([^"]+)", "([^"]+)" "([^"]+)" in the "([^"]+)"$/
     * @Transform /^of "([^"]+)" in the "([^"]+)", "([^"]+)" "([^"]+)", "([^"]+)"$/
     * @Transform /^addressed it to "([^"]+)", "([^"]+)", "([^"]+)" "([^"]+)" in the "([^"]+)"$/
     * @Transform /^address (?:|is |as )"([^"]+)", "([^"]+)", "([^"]+)", "([^"]+)", "([^"]+)"$/
     */
    public function createNewAddressWithName($name, $street, $postcode, $city, $countryName)
    {
        [$firstName, $lastName] = explode(' ', $name);

        $exp = explode(' ', $street);
        $addition = array_pop($exp);
        $number = array_pop($exp);
        $street = implode(' ', $exp);

        return $this->exampleAddressFactory->create([
            'country_code' => $this->countryNameConverter->convertToCode($countryName),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'company' => null,
            'customer' => null,
            'phone_number' => null,
            'city' => $city,
            'street' => $street,
            'postcode' => $postcode,
            'number' => $number,
            'addition' => $addition,
        ]);
    }
}
