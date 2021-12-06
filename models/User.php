<?php


namespace BotConstructor;


class User
{
    private int $id;

    private int $telegramId;

    private string $dateSign;

    private string $firstName;

    private string $lastName;

    private string $username;

    private ?string $phone;

    private ?bool $agreement;

    private ?bool $isBot;

    private ?string $languageCode;

    public function __construct() {

    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getTelegramId(): int
    {
        return $this->telegramId;
    }

    /**
     * @param int $telegramId
     */
    public function setTelegramId(int $telegramId): void
    {
        $this->telegramId = $telegramId;
    }

    /**
     * @return string
     */
    public function getDateSign(): string
    {
        return $this->dateSign;
    }

    /**
     * @param string $dateSign
     */
    public function setDateSign(string $dateSign): void
    {
        $this->dateSign = $dateSign;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return ?string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param ?string $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return ?bool
     */
    public function isAgreement(): ?bool
    {
        return $this->agreement;
    }

    /**
     * @param ?bool $agreement
     */
    public function setAgreement(?bool $agreement): void
    {
        $this->agreement = $agreement;
    }

    /**
     * @return bool|null
     */
    public function getIsBot(): ?bool
    {
        return $this->isBot;
    }

    /**
     * @param bool|null $isBot
     */
    public function setIsBot(?bool $isBot): void
    {
        $this->isBot = $isBot;
    }

    /**
     * @return string|null
     */
    public function getLanguageCode(): ?string
    {
        return $this->languageCode;
    }

    /**
     * @param string|null $languageCode
     */
    public function setLanguageCode(?string $languageCode): void
    {
        $this->languageCode = $languageCode;
    }

}
