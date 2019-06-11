<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The business.
 *
 * @package App\Entity
 * @author  Clément Cazaud <opportus@gmail.com>
 * @license https://github.com/opportus/demo-rest-api/blob/master/LICENSE.md MIT
 *
 * @ORM\Entity()
 * @ORM\Table(name="business")
 */
class Business extends AbstractEntity
{
    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length(max=255)
     */
    private $name;

    /**
     * @var ArrayCollection $users
     *
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="business", cascade={"remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $users;

    /**
     * Constructs the business.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct();

        $this->name = $name;
        $this->users = new ArrayCollection();
    }

    /**
     * Gets the name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Gets the users.
     *
     * @return User[]
     */
    public function getUsers(): array
    {
        return $this->users->toArray();
    }
}
