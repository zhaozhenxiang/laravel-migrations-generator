<?php

namespace KitLoong\MigrationsGenerator\Migration\Blueprint;

class Method
{
    /**
     * @var mixed[]
     */
    private array $values;

    /**
     * @var \KitLoong\MigrationsGenerator\Migration\Blueprint\Method[]
     */
    private array $chains;

    /**
     * Method constructor.
     *
     * @param  string  $name  Method name.
     * @param  mixed  ...$values  Method arguments.
     */
    public function __construct(private string $name, mixed ...$values)
    {
        $this->values = $values;
        $this->chains = [];
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed[]
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * Chain method.
     *
     * @param  string  $name  Method name.
     * @param  mixed  ...$values  Method arguments.
     * @return $this
     */
    public function chain(string $name, mixed ...$values): self
    {
        $this->chains[] = new self($name, ...$values);
        return $this;
    }

    /**
     * Checks if chain name exists.
     *
     * @param  string  $name  Method name.
     */
    public function hasChain(string $name): bool
    {
        foreach ($this->chains as $chain) {
            if ($chain->getName() === $name) {
                return true;
            }
        }

        return false;
    }

    /**
     * Total chain.
     */
    public function countChain(): int
    {
        return count($this->chains);
    }

    /**
     * Get a list of chained methods.
     *
     * @return \KitLoong\MigrationsGenerator\Migration\Blueprint\Method[]
     */
    public function getChains(): array
    {
        return $this->chains;
    }
}
