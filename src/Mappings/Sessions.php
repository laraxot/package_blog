<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Sessions
 *
 * @ORM\Table(name="sessions", uniqueConstraints={@ORM\UniqueConstraint(name="sessions_id_unique", columns={"id"})})
 * @ORM\Entity
 */
class Sessions
{
    /**
     * @var string
     *
     * @ORM\Column(name="id", type="string", length=191, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true, options={"unsigned"=true})
     */
    private $userId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ip_address", type="string", length=45, nullable=true)
     */
    private $ipAddress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_agent", type="text", length=65535, nullable=true)
     */
    private $userAgent;

    /**
     * @var string
     *
     * @ORM\Column(name="payload", type="text", length=65535, nullable=false)
     */
    private $payload;

    /**
     * @var int
     *
     * @ORM\Column(name="last_activity", type="integer", nullable=false)
     */
    private $lastActivity;
}
