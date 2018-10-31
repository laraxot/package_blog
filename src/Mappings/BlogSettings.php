<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogSettings
 *
 * @ORM\Table(name="blog_settings")
 * @ORM\Entity
 */
class BlogSettings
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
     * @ORM\Column(name="text_editor", type="string", length=255, nullable=false)
     */
    private $textEditor;

    /**
     * @var string
     *
     * @ORM\Column(name="public_url", type="string", length=255, nullable=false)
     */
    private $publicUrl;

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
