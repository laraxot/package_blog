<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostCount.
 *
 * @ORM\Table(name="blog_post_count", indexes={@ORM\Index(name="blog_post_count_post_id_index", columns={"post_id"}), @ORM\Index(name="blog_post_count_relationship_index", columns={"relationship"}), @ORM\Index(name="blog_post_count_type_index", columns={"type"})})
 * @ORM\Entity
 */
class BlogPostCount
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
     * @ORM\Column(name="relationship", type="string", length=50, nullable=false)
     */
    private $relationship;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="q", type="integer", nullable=false)
     */
    private $q;

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
     * @ORM\Column(name="deleted_ip", type="string", length=255, nullable=true)
     */
    private $deletedIp;

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
}
