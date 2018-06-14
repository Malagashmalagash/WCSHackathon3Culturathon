<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ArtWork", mappedBy="user")
     */
    private $artWorks;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255)
     */
    private $firstName;

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Add artWork
     *
     * @param \AppBundle\Entity\ArtWork $artWork
     *
     * @return User
     */
    public function addArtWork(\AppBundle\Entity\ArtWork $artWork)
    {
        $this->artWorks[] = $artWork;

        return $this;
    }

    /**
     * Remove artWork
     *
     * @param \AppBundle\Entity\ArtWork $artWork
     */
    public function removeArtWork(\AppBundle\Entity\ArtWork $artWork)
    {
        $this->artWorks->removeElement($artWork);
    }

    /**
     * Get artWorks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArtWorks()
    {
        return $this->artWorks;
    }
}
