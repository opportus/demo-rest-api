<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The user.
 *
 * @package App\Entity
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 *
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class User extends AbstractEntity implements UserInterface
{
    /**
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     * @Assert\Email()
     */
    private $username;

    /**
     * @var Business $business
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Business")
     * @ORM\JoinColumn(name="business_id", referencedColumnName="id", nullable=false)
     * @Assert\NotNull()
     * @Assert\Valid()
     */
    private $business;

    /**
     * Constructs the user.
     *
     * @param string $username
     */
    public function __construct(string $username, Business $business)
    {
        parent::__construct();

        $this->username = $username;
        $this->business = $business;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public function getBusiness(): Business
    {
        return $this->business;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        return;
    }
}
