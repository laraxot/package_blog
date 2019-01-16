<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostCats.
 *
 * @ORM\Table(name="blog_post_cats", indexes={@ORM\Index(name="blog_post_cats_post_id_index", columns={"post_id"})})
 * @ORM\Entity
 */
class BlogPostCats
{
    /**
     * @var int
     *
     * @ORM\Column(name="post_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $postId;

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
}
