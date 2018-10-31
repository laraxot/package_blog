<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostCategories
 *
 * @ORM\Table(name="blog_post_categories", indexes={@ORM\Index(name="blog_post_categories_post_id_index", columns={"post_id"})})
 * @ORM\Entity
 */
class BlogPostCategories
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


}
