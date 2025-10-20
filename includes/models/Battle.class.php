<?php
class Battle {
    private int $id;
    private Monster $winner;
    private Monster $creature1;
    private Monster $creature2;
    private DateTime $created_at;

    private function __construct(int $id, Monster $winner, Monster $creature1, 
                                Monster $creature2)
    {
        $this->id = $id;
        $this->winner = $winner;
        $this->creature1 = $creature1;
        $this->creature2 = $creature2;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of winner
     */ 
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * Set the value of winner
     *
     * @return  self
     */ 
    public function setWinner(Monster $winner)
    {
        $this->winner = $winner;

        return $this;
    }

    /**
     * Get the value of creature1
     */ 
    public function getCreature1()
    {
        return $this->creature1;
    }

    /**
     * Set the value of creature1
     *
     * @return  self
     */ 
    public function setCreature1(Monster $creature1)
    {
        $this->creature1 = $creature1;

        return $this;
    }

    /**
     * Get the value of creature2
     */ 
    public function getCreature2()
    {
        return $this->creature2;
    }

    /**
     * Set the value of creature2
     *
     * @return  self
     */ 
    public function setCreature2(Monster $creature2)
    {
        $this->creature2 = $creature2;

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
    public function setCreated_at(DateTime$created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }
}