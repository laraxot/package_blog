<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostEvents.
 *
 * @ORM\Table(name="blog_post_events", indexes={@ORM\Index(name="blog_post_events_post_id_index", columns={"post_id"})})
 * @ORM\Entity
 */
class BlogPostEvents
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
     * @ORM\Column(name="bio", type="text", length=65535, nullable=true)
     */
    private $bio;

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
