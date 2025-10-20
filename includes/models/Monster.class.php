<?php
class Monster{
    private int $id;
    private string $name;
    private string $description;
    private Type $type;
    private int $heads;
    private string $image;
    private int $health;
    private int $attack;
    private int $defense;
    private int $is_fusion;
    private User $user;
    private DateTime $created_at;

    public function __construct(int $id, string $name, string $description, Type $type, int $heads, string $image, int $health, int $attack, int $defense, int $is_fusion, User $user)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;
        $this->heads = $heads;
        $this->image = $image;
        $this->health = $health;
        $this->attack = $attack;
        $this->defense = $defense;
        $this->is_fusion = $is_fusion;
        $this->user = $user;
    }

    // Getters and setters for each property
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    public function getAttack(): int
    {
        return $this->attack;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setHealth(int $health): self
    {
        $this->health = $health;
        return $this;
    }

    public function setAttack(int $attack): self
    {
        $this->attack = $attack;
        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */ 
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of heads
     */ 
    public function getHeads()
    {
        return $this->heads;
    }

    /**
     * Set the value of heads
     *
     * @return  self
     */ 
    public function setHeads($heads)
    {
        $this->heads = $heads;

        return $this;
    }

    /**
     * Get the value of image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of defense
     */ 
    public function getDefense()
    {
        return $this->defense;
    }

    /**
     * Set the value of defense
     *
     * @return  self
     */ 
    public function setDefense(int $defense)
    {
        $this->defense = $defense;

        return $this;
    }

    /**
     * Get the value of is_fusion
     */ 
    public function getIs_fusion()
    {
        return $this->is_fusion;
    }

    /**
     * Set the value of is_fusion
     *
     * @return  self
     */ 
    public function setIs_fusion(int $is_fusion)
    {
        $this->is_fusion = $is_fusion;

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

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }
}