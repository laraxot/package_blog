<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostShopItems.
 *
 * @ORM\Table(name="blog_post_shop_items")
 * @ORM\Entity
 */
class BlogPostShopItems
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
     * @var int
     *
     * @ORM\Column(name="post_var_cat_id", type="integer", nullable=false)
     */
    private $postVarCatId;

    /**
     * @var string
     *
     * @ORM\Column(name="post_id_adds", type="string", length=255, nullable=false)
     */
    private $postIdAdds;

    /**
     * @var string
     *
     * @ORM\Column(name="post_id_subs", type="string", length=255, nullable=false)
     */
    private $postIdSubs;

    /**
     * @var int
     *
     * @ORM\Column(name="num", type="integer", nullable=false)
     */
    private $num;

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
