<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostRelated.
 *
 * @ORM\Table(name="blog_post_related", indexes={@ORM\Index(name="blog_post_related_post_id_index", columns={"post_id"}), @ORM\Index(name="blog_post_related_related_id_index", columns={"related_id"}), @ORM\Index(name="blog_post_related_type_index", columns={"type"})})
 * @ORM\Entity
 */
class BlogPostRelated
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
     * @var int|null
     *
     * @ORM\Column(name="post_id", type="integer", nullable=true)
     */
    private $postId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="related_id", type="integer", nullable=true)
     */
    private $relatedId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="pos", type="integer", nullable=true)
     */
    private $pos;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type", type="string", length=50, nullable=true)
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="note", type="text", length=65535, nullable=true)
     */
    private $note;

    /**
     * @var int|null
     *
     * @ORM\Column(name="sons_count", type="integer", nullable=true)
     */
    private $sonsCount;

    /**
     * @var int|null
     *
     * @ORM\Column(name="parents_count", type="integer", nullable=true)
     */
    private $parentsCount;

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
     * @ORM\Column(name="price", type="decimal", precision=10, scale=3, nullable=true)
     */
    private $price;

    /**
     * @var string|null
     *
     * @ORM\Column(name="price_currency", type="string", length=255, nullable=true)
     */
    private $priceCurrency;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="launch_available", type="boolean", nullable=true)
     */
    private $launchAvailable;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="dinner_available", type="boolean", nullable=true)
     */
    private $dinnerAvailable;
}
