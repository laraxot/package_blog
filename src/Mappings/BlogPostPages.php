<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostPages
 *
 * @ORM\Table(name="blog_post_pages", indexes={@ORM\Index(name="blog_post_pages_post_id_index", columns={"post_id"})})
 * @ORM\Entity
 */
class BlogPostPages
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
     * @ORM\Column(name="published_at", type="datetime", nullable=true)
     */
    private $publishedAt;

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
