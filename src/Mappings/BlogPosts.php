<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPosts
 *
 * @ORM\Table(name="blog_posts", indexes={@ORM\Index(name="blog_posts_post_id_index", columns={"post_id"}), @ORM\Index(name="blog_posts_type_index", columns={"type"}), @ORM\Index(name="blog_posts_lang_index", columns={"lang"})})
 * @ORM\Entity
 */
class BlogPosts
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
     * @var string|null
     *
     * @ORM\Column(name="lang", type="string", length=3, nullable=true)
     */
    private $lang;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="subtitle", type="text", length=65535, nullable=true)
     */
    private $subtitle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="guid", type="string", length=255, nullable=true)
     */
    private $guid;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=true)
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(name="txt", type="text", length=65535, nullable=true)
     */
    private $txt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image_src", type="string", length=255, nullable=true)
     */
    private $imageSrc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image_alt", type="string", length=255, nullable=true)
     */
    private $imageAlt;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image_title", type="string", length=255, nullable=true)
     */
    private $imageTitle;

    /**
     * @var string|null
     *
     * @ORM\Column(name="meta_description", type="text", length=65535, nullable=true)
     */
    private $metaDescription;

    /**
     * @var string|null
     *
     * @ORM\Column(name="meta_keywords", type="text", length=65535, nullable=true)
     */
    private $metaKeywords;

    /**
     * @var int|null
     *
     * @ORM\Column(name="author_id", type="integer", nullable=true)
     */
    private $authorId;

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
     * @var int|null
     *
     * @ORM\Column(name="category_id", type="integer", nullable=true)
     */
    private $categoryId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string|null
     *
     * @ORM\Column(name="content", type="text", length=65535, nullable=true)
     */
    private $content;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="published", type="boolean", nullable=true)
     */
    private $published;

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

    /**
     * @var string|null
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @var string|null
     *
     * @ORM\Column(name="url_lang", type="text", length=65535, nullable=true)
     */
    private $urlLang;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image_resize_src", type="text", length=65535, nullable=true)
     */
    private $imageResizeSrc;

    /**
     * @var string|null
     *
     * @ORM\Column(name="linked_count", type="text", length=65535, nullable=true)
     */
    private $linkedCount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="related_count", type="text", length=65535, nullable=true)
     */
    private $relatedCount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="relatedrev_count", type="text", length=65535, nullable=true)
     */
    private $relatedrevCount;
}
