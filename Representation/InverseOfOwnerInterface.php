<?php
namespace Kna\HalBundle\Representation;


interface InverseOfOwnerInterface
{
    /**
     * @return object
     */
    public function getOwningSideEntity();

    /**
     * @param object $owningSideEntity
     */
    public function setOwningSideEntity($owningSideEntity): void;

    /**
     * @return object
     */
    public function getInverseSideEntity();

    /**
     * @param object $inverseSideEntity
     */
    public function setInverseSideEntity($inverseSideEntity): void;

    /**
     * @return string
     */
    public function getRoute(): string;

    /**
     * @param string $route
     */
    public function setRoute(string $route): void;

    /**
     * @return array
     */
    public function getParameters(): array;

    /**
     * @param array $parameters
     */
    public function setParameters(array $parameters): void;

    /**
     * @return bool
     */
    public function isAbsolute(): bool;

    /**
     * @param bool $absolute
     */
    public function setAbsolute(bool $absolute): void;

    /**
     * @return string
     */
    public function getRel(): string;

    /**
     * @param string $rel
     */
    public function setRel(string $rel): void;
}