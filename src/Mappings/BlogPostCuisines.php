<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostCuisines
 *
 * @ORM\Table(name="blog_post_cuisines", uniqueConstraints={@ORM\UniqueConstraint(name="blog_post_cuisines_post_id_unique", columns={"post_id"})}, indexes={@ORM\Index(name="blog_post_cuisines_post_id_index", columns={"post_id"})})
 * @ORM\Entity
 */
class BlogPostCuisines
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
}
