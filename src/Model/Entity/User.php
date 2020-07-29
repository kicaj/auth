<?php
namespace Auth\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

class User extends Entity
{

    /**
     * User statuses.
     */
    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'email' => true,
        'password' => true,
        'uuid' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'user_groups' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    /**
     * List of statuses.
     *
     * @return array Statuses list.
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_INACTIVE => __d('admin', 'Inactive'),
            self::STATUS_ACTIVE => __d('admin', 'Active'),
        ];
    }

    /**
     * Get status.
     *
     * @param integer $status Status identifier.
     * @return string Status name.
     */
    public static function getStatus($status)
    {
        $statuses = self::getStatuses();

        if (array_key_exists($status, $statuses)) {
            return $statuses[$status];
        }

        return '';
    }

    /**
     * Set password hasher
     *
     * @return boolean|string Hased password
     */
    protected function _setPassword($value)
    {
        return (new DefaultPasswordHasher)->hash($value);
    }
}
