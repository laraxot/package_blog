<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostContents
 *
 * @ORM\Table(name="blog_post_contents")
 * @ORM\Entity
 */
class BlogPostContents
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
     * @var string
     *
     * @ORM\Column(name="content_type", type="string", length=255, nullable=false)
     */
    private $contentType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="content_source", type="string", length=255, nullable=true)
     */
    private $contentSource;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=false)
     */
    private $content;

    /**
     * @var int
     *
     * @ORM\Column(name="x", type="integer", nullable=false)
     */
    private $x;

    /**
     * @var int
     *
     * @ORM\Column(name="y", type="integer", nullable=false)
     */
    private $y;

    /**
     * @var int
     *
     * @ORM\Column(name="width", type="integer", nullable=false)
     */
    private $width;

    /**
     * @var int
     *
     * @ORM\Column(name="height", type="integer", nullable=false)
     */
    private $height;

    /**
     * @var int
     *
     * @ORM\Column(name="post_id", type="integer", nullable=false)
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
