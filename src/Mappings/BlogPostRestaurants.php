<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostRestaurants
 *
 * @ORM\Table(name="blog_post_restaurants", uniqueConstraints={@ORM\UniqueConstraint(name="blog_post_restaurants_post_id_unique", columns={"post_id"})}, indexes={@ORM\Index(name="post_id", columns={"post_id"})})
 * @ORM\Entity
 */
class BlogPostRestaurants
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
     * @ORM\Column(name="status", type="string", length=40, nullable=true)
     */
    private $status;

    /**
     * @var string|null
     *
     * @ORM\Column(name="min_order", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $minOrder;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address1", type="text", length=65535, nullable=true)
     */
    private $address1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address2", type="text", length=65535, nullable=true)
     */
    private $address2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address3", type="text", length=65535, nullable=true)
     */
    private $address3;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="text", length=65535, nullable=true)
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="zip_code", type="text", length=65535, nullable=true)
     */
    private $zipCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country", type="text", length=65535, nullable=true)
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(name="state", type="text", length=65535, nullable=true)
     */
    private $state;

    /**
     * @var string|null
     *
     * @ORM\Column(name="latitude", type="decimal", precision=16, scale=13, nullable=true)
     */
    private $latitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="longitude", type="decimal", precision=16, scale=13, nullable=true)
     */
    private $longitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="yelp_url", type="text", length=65535, nullable=true)
     */
    private $yelpUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(name="is_closed", type="text", length=65535, nullable=true)
     */
    private $isClosed;

    /**
     * @var string|null
     *
     * @ORM\Column(name="price", type="text", length=65535, nullable=true)
     */
    private $price;

    /**
     * @var string|null
     *
     * @ORM\Column(name="review_count", type="text", length=65535, nullable=true)
     */
    private $reviewCount;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rating", type="text", length=65535, nullable=true)
     */
    private $rating;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="text", length=65535, nullable=true)
     */
    private $phone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="display_phone", type="text", length=65535, nullable=true)
     */
    private $displayPhone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="guid", type="string", length=255, nullable=true)
     */
    private $guid;

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
     * @ORM\Column(name="deleted_ip", type="string", length=255, nullable=true)
     */
    private $deletedIp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="created_ip", type="string", length=255, nullable=true)
     */
    private $createdIp;

    /**
     * @var string|null
     *
     * @ORM\Column(name="updated_ip", type="string", length=255, nullable=true)
     */
    private $updatedIp;

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

    /**
     * @var string|null
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="formatted_address", type="string", length=255, nullable=true)
     */
    private $formattedAddress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="delivery_cost", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $deliveryCost;

    /**
     * @var string|null
     *
     * @ORM\Column(name="delivery_options", type="string", length=255, nullable=true)
     */
    private $deliveryOptions;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="order_action", type="boolean", nullable=true)
     */
    private $orderAction;

    /**
     * @var string|null
     *
     * @ORM\Column(name="price_currency", type="string", length=255, nullable=true)
     */
    private $priceCurrency;

    /**
     * @var string|null
     *
     * @ORM\Column(name="price_range", type="string", length=255, nullable=true)
     */
    private $priceRange;
}
