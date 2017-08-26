<?php
namespace frontend\models;

use yii\db\ActiveRecord;

class Order extends ActiveRecord{
    //送货方式
    public static $deliveries=[
        1=>['顺丰快递',20,'价格贵，速度快，服务好'],
        2=>['EMS',15,'价格贵，速度一般，服务一般'],
        3=>['邮政',15,'价格贵，速度慢，服务一般'],
    ];
    //支付方式
    public static $pays=[
        1=>['货到付款','送货上门后再收款，支持现金、POS机刷卡、支票支付'],
        2=>['在线支付','即时到帐，支持绝大数银行借记卡及部分银行信用卡'],
        3=>['上门自提','自提时付款，支持现金、POS刷卡、支票支付'],
    ];


    public function rules()
    {
        return [
            [['member_id', 'name', 'province', 'city', 'area', 'address', 'tel','delivery_id','delivery_name','delivery_price','payment_id','payment_name',], 'required'],
            [['member_id', 'delivery_id', 'payment_id'], 'integer'],
            [['address', 'payment_name'], 'string', 'max' => 255],
            [['total','status','trade_no','create_time'],'safe']
        ];
    }
}