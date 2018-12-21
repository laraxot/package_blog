<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostProfiles
 *
 * @ORM\Table(name="blog_post_profiles", indexes={@ORM\Index(name="blog_post_profiles_post_id_index", columns={"post_id"}), @ORM\Index(name="blog_post_profiles_auth_user_id_index", columns={"auth_user_id"})})
 * @ORM\Entity
 */
class BlogPostProfiles
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
     * @ORM\Column(name="deleted_by", type="string", length=255, nullable=true)
     */
    private $deletedBy;

    /**
     * @var string|null
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="surname", type="string", length=255, nullable=true)
     */
    private $surname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var int|null
     *
     * @ORM\Column(name="auth_user_id", type="integer", nullable=true)
     */
    private $authUserId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="locality", type="string", length=255, nullable=true)
     */
    private $locality;

    /**
     * @var string|null
     *
     * @ORM\Column(name="locality_short", type="string", length=255, nullable=true)
     */
    private $localityShort;

    /**
     * @var string|null
     *
     * @ORM\Column(name="administrative_area_level_3", type="string", length=255, nullable=true)
     */
    private $administrativeAreaLevel3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="administrative_area_level_3_short", type="string", length=255, nullable=true)
     */
    private $administrativeAreaLevel3Short;

    /**
     * @var string|null
     *
     * @ORM\Column(name="administrative_area_level_2", type="string", length=255, nullable=true)
     */
    private $administrativeAreaLevel2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="administrative_area_level_2_short", type="string", length=255, nullable=true)
     */
    private $administrativeAreaLevel2Short;

    /**
     * @var string|null
     *
     * @ORM\Column(name="administrative_area_level_1", type="string", length=255, nullable=true)
     */
    private $administrativeAreaLevel1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="administrative_area_level_1_short", type="string", length=255, nullable=true)
     */
    private $administrativeAreaLevel1Short;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country_short", type="string", length=255, nullable=true)
     */
    private $countryShort;

    /**
     * @var string|null
     *
     * @ORM\Column(name="street_number", type="string", length=255, nullable=true)
     */
    private $streetNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="street_number_short", type="string", length=255, nullable=true)
     */
    private $streetNumberShort;

    /**
     * @var string|null
     *
     * @ORM\Column(name="route", type="string", length=255, nullable=true)
     */
    private $route;

    /**
     * @var string|null
     *
     * @ORM\Column(name="route_short", type="string", length=255, nullable=true)
     */
    private $routeShort;

    /**
     * @var string|null
     *
     * @ORM\Column(name="postal_code", type="string", length=255, nullable=true)
     */
    private $postalCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="postal_code_short", type="string", length=255, nullable=true)
     */
    private $postalCodeShort;

    /**
     * @var string|null
     *
     * @ORM\Column(name="premise", type="string", length=255, nullable=true)
     */
    private $premise;

    /**
     * @var string|null
     *
     * @ORM\Column(name="premise_short", type="string", length=255, nullable=true)
     */
    private $premiseShort;

    /**
     * @var string|null
     *
     * @ORM\Column(name="googleplace_url", type="string", length=255, nullable=true)
     */
    private $googleplaceUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="googleplace_url_short", type="string", length=255, nullable=true)
     */
    private $googleplaceUrlShort;

    /**
     * @var string|null
     *
     * @ORM\Column(name="point_of_interest", type="string", length=255, nullable=true)
     */
    private $pointOfInterest;

    /**
     * @var string|null
     *
     * @ORM\Column(name="point_of_interest_short", type="string", length=255, nullable=true)
     */
    private $pointOfInterestShort;

    /**
     * @var string|null
     *
     * @ORM\Column(name="political", type="string", length=255, nullable=true)
     */
    private $political;

    /**
     * @var string|null
     *
     * @ORM\Column(name="political_short", type="string", length=255, nullable=true)
     */
    private $politicalShort;

    /**
     * @var string|null
     *
     * @ORM\Column(name="campground", type="string", length=255, nullable=true)
     */
    private $campground;

    /**
     * @var string|null
     *
     * @ORM\Column(name="campground_short", type="string", length=255, nullable=true)
     */
    private $campgroundShort;
}
