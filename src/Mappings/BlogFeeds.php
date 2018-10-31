<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogFeeds
 *
 * @ORM\Table(name="blog_feeds", indexes={@ORM\Index(name="blog_feeds_post_id_index", columns={"post_id"})})
 * @ORM\Entity
 */
class BlogFeeds
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
