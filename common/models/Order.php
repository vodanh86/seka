<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $customer_type
 * @property string $surname
 * @property string $name
 * @property string $country
 * @property string $region
 * @property string $city
 * @property string $address
 * @property string $zip_code
 * @property string $phone
 * @property string $email
 * @property string $notes
 * @property string $status
 *
 * @property OrderItem[] $orderItems
 */
class Order extends \yii\db\ActiveRecord
{
	//order status
	const STATUS_NEW = 0;
	const STATUS_WAIT_CONFIRM = 1;
	const STATUS_CONFIRM = 2;
	const STATUS_ORDER = 3;
	const STATUS_CHINA_STORE = 4;
	const STATUS_VIETNAM_STORE = 5;
    const STATUS_PARTIAL_SHIP = 6;
    const STATUS_SHIP = 7;
    const STATUS_BILL = 8;
	const STATUS_CANCEL = 9;
	
	//customer type
	const GUEST = 0;
	const USER = 1;
	
	public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_NEW],
			['status', 'in', 'range' => [self::STATUS_NEW, self::STATUS_WAIT_CONFIRM, self::STATUS_CONFIRM, self::STATUS_ORDER, self::STATUS_CHINA_STORE, self::STATUS_VIETNAM_STORE, self::STATUS_PARTIAL_SHIP, self::STATUS_SHIP, self::STATUS_BILL, self::STATUS_CANCEL]],
            [['address', 'notes'], 'string'],
            [['user_id'], 'integer'],
            ['customer_type', 'default', 'value' => self::GUEST],
			['customer_type', 'in', 'range' => [self::GUEST, self::USER]],
            [['surname', 'name', 'country', 'region', 'city', 'zip_code', 'phone', 'email', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'customer_type' => 'Customer Type',
            'user_id' => 'User Id',
            'surname' => 'Surname',
            'name' => 'Name',
            'country' => 'Country',
            'region' => 'Region',
            'city' => 'City',
            'address' => 'Address',
            'zip_code' => 'Zip Code',
            'phone' => 'Phone',
            'email' => 'Email',
            'notes' => 'Notes',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }
}
