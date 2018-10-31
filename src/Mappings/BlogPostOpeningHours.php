<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostOpeningHours
 *
 * @ORM\Table(name="blog_post_opening_hours")
 * @ORM\Entity
 */
class BlogPostOpeningHours
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="post_id", type="integer", nullable=false)
     */
    private $postId;

    /**
     * @var string
     *
     * @ORM\Column(name="day_name", type="string", length=255, nullable=false)
     */
    private $dayName;

    /**
     * @var int
     *
     * @ORM\Column(name="day_of_week", type="integer", nullable=false)
     */
    private $dayOfWeek;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="open_at", type="time", nullable=true)
     */
    private $openAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="close_at", type="time", nullable=true)
     */
    private $closeAt;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="is_closed", type="boolean", nullable=true)
     */
    private $isClosed;

    /**
     * @var string|null
     *
     * @ORM\Column(name="note", type="text", length=65535, nullable=true)
     */
    private $note;

    /**
     * @var string|null
     *
     * @ORM\Column(name="created_by", type="string", length=255, nullable=true)
     */
    private $createdBy;

    /**
     * @var string|null
     *
     * @ORM\Column(name="updated_by", type="string", length=255, nullable=true)
     */
    private $updatedBy;

    /**
     * @var string|null
     *
     * @ORM\Column(name="deleted_by", type="string", length=255, nullable=true)
     */
    private $deletedBy;

    /**
     * @var string|null
     *
     * @ORM\Column(name="created_ip", type="string", length=255, nullable=true)
     */
    private $createdIp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="updated_ip", type="string", length=255, nullable=true)
     */
    private $updatedIp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="deleted_ip", type="string", length=255, nullable=true)
     */
    private $deletedIp;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;


}
