<?php
namespace Kna\HalBundle\Action;


class ActionFactory
{
    /**
     * @var ActionInterface[]
     */
    protected $actions = [];

    /**
     * @param ActionInterface $action
     */
    public function registerAction(ActionInterface $action): void
    {
        $this->actions[$action->getName()] = $action;
    }

    /**
     * @param string $name
     * @return ActionInterface
     */
    public function get(string $name): ActionInterface
    {
        if (array_key_exists($name, $this->actions)) {
            return $this->actions[$name];
        }
        throw new \InvalidArgumentException('Action "' . $name .  '" not found.');
    }

    public function getRegisteredActions(): array
    {
        return $this->actions;
    }

    public function getRegisteredActionNames(): array
    {
        return array_keys($this->actions);
    }
}