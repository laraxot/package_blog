<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostShopItemVars
 *
 * @ORM\Table(name="blog_post_shop_item_vars", indexes={@ORM\Index(name="blog_post_shop_item_vars_post_shop_item_id_index", columns={"post_shop_item_id"})})
 * @ORM\Entity
 */
class BlogPostShopItemVars
{
    /**
     * @var int
     *
     * @ORM\Column(name="post_shop_item_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $postShopItemId;

    /**
     * @var int
     *
     * @ORM\Column(name="post_cat_id", type="integer", nullable=false)
     */
    private $postCatId;

    /**
     * @var int
     *
     * @ORM\Column(name="post_id", type="integer", nullable=false)
     */
    private $postId;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", length=65535, nullable=false)
     */
    private $note;

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


}
