<?php
namespace Kna\HalBundle\Action;


class ActionResult
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var array
     */
    protected $parameters;

    public function __construct(string $message, array $parameters = [])
    {
        $this->message = $message;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public static function create(string $message, array $parameters = []): ActionResult
    {
        return new self($message, $parameters);
    }
}
