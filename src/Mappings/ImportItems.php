<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * ImportItems
 *
 * @ORM\Table(name="import_items")
 * @ORM\Entity
 */
class ImportItems
{
    /**
     * @var int
     *
     * @ORM\Column(name="post_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $postId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="term", type="string", length=255, nullable=true)
     */
    private $term;

    /**
     * @var string|null
     *
     * @ORM\Column(name="locality", type="string", length=255, nullable=true)
     */
    private $locality;

    /**
     * @var string|null
     *
     * @ORM\Column(name="administrative_area_level_3", type="string", length=255, nullable=true)
     */
    private $administrativeAreaLevel3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="administrative_area_level_2", type="string", length=255, nullable=true)
     */
    private $administrativeAreaLevel2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="administrative_area_level_1", type="string", length=255, nullable=true)
     */
    private $administrativeAreaLevel1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(name="street_number", type="string", length=255, nullable=true)
     */
    private $streetNumber;

    /**
     * @var string|null
     *
     * @ORM\Column(name="route", type="string", length=255, nullable=true)
     */
    private $route;

    /**
     * @var string|null
     *
     * @ORM\Column(name="postal_code", type="string", length=255, nullable=true)
     */
    private $postalCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="premise", type="string", length=255, nullable=true)
     */
    private $premise;

    /**
     * @var string|null
     *
     * @ORM\Column(name="googleplace_url", type="string", length=255, nullable=true)
     */
    private $googleplaceUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="point_of_interest", type="string", length=255, nullable=true)
     */
    private $pointOfInterest;

    /**
     * @var string|null
     *
     * @ORM\Column(name="political", type="string", length=255, nullable=true)
     */
    private $political;

    /**
     * @var string|null
     *
     * @ORM\Column(name="campground", type="string", length=255, nullable=true)
     */
    private $campground;

    /**
     * @var string|null
     *
     * @ORM\Column(name="latitude", type="decimal", precision=15, scale=10, nullable=true)
     */
    private $latitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="longitude", type="decimal", precision=15, scale=10, nullable=true)
     */
    private $longitude;

    /**
     * @var int|null
     *
     * @ORM\Column(name="radius", type="integer", nullable=true)
     */
    private $radius;

    /**
     * @var string|null
     *
     * @ORM\Column(name="formatted_address", type="string", length=255, nullable=true)
     */
    private $formattedAddress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nearest_street", type="string", length=255, nullable=true)
     */
    private $nearestStreet;

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
     * @ORM\Column(name="locality_short", type="string", length=255, nullable=true)
     */
    private $localityShort;

    /**
     * @var string|null
     *
     * @ORM\Column(name="administrative_area_level_2_short", type="string", length=255, nullable=true)
     */
    private $administrativeAreaLevel2Short;

    /**
     * @var string|null
     *
     * @ORM\Column(name="administrative_area_level_1_short", type="string", length=255, nullable=true)
     */
    private $administrativeAreaLevel1Short;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country_short", type="string", length=255, nullable=true)
     */
    private $countryShort;
}
