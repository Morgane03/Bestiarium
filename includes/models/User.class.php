<?php

class User
{
    private int $id;
    private string $pseudo;
    private string $password;
    private string $email;
    private DateTime $created_at;

    public function __construct(int $id, string $pseudo, string $password, string $email)
    {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->password = $password;
        $this->email = $email;
    }

    // Getters and setters for each property
    public function getId()
    {
        return $this->id;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of pseudo
     *
     * @return  self
     */ 
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
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
