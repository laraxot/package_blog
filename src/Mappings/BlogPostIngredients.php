<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostIngredients
 *
 * @ORM\Table(name="blog_post_ingredients", indexes={@ORM\Index(name="blog_post_ingredients_post_id_index", columns={"post_id"})})
 * @ORM\Entity
 */
class BlogPostIngredients
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
     * @var string
     *
     * @ORM\Column(name="created_by", type="string", length=255, nullable=false)
     */
    private $createdBy;

    /**
     * @var string
     *
     * @ORM\Column(name="updated_by", type="string", length=255, nullable=false)
     */
    private $updatedBy;

    /**
     * @var string
     *
     * @ORM\Column(name="deleted_by", type="string", length=255, nullable=false)
     */
    private $deletedBy;

    /**
     * @var string
     *
     * @ORM\Column(name="created_ip", type="string", length=45, nullable=false)
     */
    private $createdIp;

    /**
     * @var string
     *
     * @ORM\Column(name="updated_ip", type="string", length=45, nullable=false)
     */
    private $updatedIp;

    /**
     * @var string
     *
     * @ORM\Column(name="deleted_ip", type="string", length=45, nullable=false)
     */
    private $deletedIp;

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
     * @var \DateTime|null
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;


}
