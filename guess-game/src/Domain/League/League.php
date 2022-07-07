<?php

namespace Guess\Domain\League;

class League
{
    private int $id;
    private string $name;
    private string $leagueNameSlugged;
    private string $logo;
    private int $leagueApiId;
    

    /**
     * Get the value of id
     */ 
    

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    /**
     * Get the value of logo
     */ 
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set the value of logo
     *
     * @return  self
     */ 
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get the value of leagueApiId
     */ 
    public function getLeagueApiId()
    {
        return $this->leagueApiId;
    }

    /**
     * Set the value of leagueApiId
     *
     * @return  self
     */ 
    public function setLeagueApiId($leagueApiId)
    {
        $this->leagueApiId = $leagueApiId;

        return $this;
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
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of leagueNameSlugged
     */ 
    public function getLeagueNameSlugged()
    {
        return $this->leagueNameSlugged;
    }

    /**
     * Set the value of leagueNameSlugged
     *
     * @return  self
     */ 
    public function setLeagueNameSlugged($leagueNameSlugged)
    {
        $this->leagueNameSlugged = $leagueNameSlugged;

        return $this;
    }
}
