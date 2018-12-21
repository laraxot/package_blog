<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Cache
 *
 * @ORM\Table(name="cache", uniqueConstraints={@ORM\UniqueConstraint(name="cache_key_unique", columns={"key"})})
 * @ORM\Entity
 */
class Cache
{
    /**
     * @var string
     *
     * @ORM\Column(name="key", type="string", length=64, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $key;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text", length=65535, nullable=false)
     */
    private $value;

    /**
     * @var int
     *
     * @ORM\Column(name="expiration", type="integer", nullable=false)
     */
    private $expiration;
}
