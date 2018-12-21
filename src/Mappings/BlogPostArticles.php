<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostArticles
 *
 * @ORM\Table(name="blog_post_articles", indexes={@ORM\Index(name="blog_post_articles_post_id_index", columns={"post_id"})})
 * @ORM\Entity
 */
class BlogPostArticles
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
     * @ORM\Column(name="article_type", type="string", length=50, nullable=true)
     */
    private $articleType;

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
}
