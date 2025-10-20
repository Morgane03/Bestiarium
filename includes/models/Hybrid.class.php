<?php

class Hybrid extends Monster {
    private int $id;
    private Monster $parent1;
    private Monster $parent2;
    private DateTime $created_at;

    public function __construct(int $id, Monster $parent1, Monster $parent2)
    {
        $this->id = $id;
        $this->parent1 = $parent1;
        $this->parent2 = $parent2;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getParent1(): Monster
    {
        return $this->parent1;
    }

    public function getParent2(): Monster
    {
        return $this->parent2;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of parent1
     *
     * @return  self
     */ 
    public function setParent1(Monster $parent1)
    {
        $this->parent1 = $parent1;

        return $this;
    }

    /**
     * Set the value of parent2
     *
     * @return  self
     */ 
    public function setParent2(Monster $parent2)
    {
        $this->parent2 = $parent2;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }
}