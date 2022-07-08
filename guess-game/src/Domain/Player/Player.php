<?php
namespace Guess\Domain\Player;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Guess\Domain\Game\Game;
use Exception;

class Player implements UserInterface 
{

    const RIGHT_GUESS_POINT = 3;

    private int $id;
    private string $username;
    private string $password;
    private string $email;
    private DateTimeInterface $createdAt;
    private int $point;
    private int $avatar;
    private bool $isActive;
    private Collection $guesses;



    public function __construct()
    {
        $this->avatar = 1;
        $this->point = 0;
        $this->createdAt = new DateTimeImmutable();
        $this->isActive = true;   
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
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
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
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
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
     * Get the value of createdAt
     */ 
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */ 
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of point
     */ 
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * Set the value of point
     *
     * @return  self
     */ 
    public function setPoint($point)
    {
        $this->point = $point;

        return $this;
    }

    /**
     * Get the value of avatar
     */ 
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     *
     * @return  self
     */ 
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get the value of isActive
     */ 
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set the value of isActive
     *
     * @return  self
     */ 
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get the value of guesses
     */ 
    public function getGuesses() : ArrayCollection
    {
        return $this->guesses;
    }

    /**
     * Set the value of guesses
     *
     * @return  self
     */ 
    public function setGuesses(ArrayCollection $guesses) 
    {
        $this->guesses = $guesses;

        return $this;
    }


    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    public function makeGuesses(Game $game, int $homeTeamGuess, int $awayTeamGuess)
    {
        if ((new DateTimeImmutable()) > $game->getGameTime()) {
            throw new Exception("Starting time passed for this game, cant make a guess");
        }

        $guess = new Guess();
        $guess->setPlayer($this);
        $guess->setGame($game);
        $guess->setCreatedAt(new DateTimeImmutable());
        $guess->setGuess($homeTeamGuess.'-'.$awayTeamGuess);

        $this->guesses->add($guess);
        $game->addGuess($guess);
    }
    
    public function pointUp(): void
    {
        $this->point += self::RIGHT_GUESS_POINT;
    }
    
}
