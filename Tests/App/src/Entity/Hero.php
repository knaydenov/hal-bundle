<?php
namespace Kna\HalBundle\Tests\App\Entity;


class Hero
{
    /**
     * @var int|null
     */
    protected $id;
    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $ability;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getAbility(): ?string
    {
        return $this->ability;
    }

    /**
     * @param string|null $ability
     */
    public function setAbility(?string $ability): void
    {
        $this->ability = $ability;
    }
}