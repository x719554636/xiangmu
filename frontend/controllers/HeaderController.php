<?php

namespace frontend\controllers;

use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Order;
use frontend\models\OrderGoods;
use yii\data\Pagination;
use yii\db\Exception;
use yii\web\Cookie;

class HeaderController extends \yii\web\Controller
{
    public $enableCsrfValidation=false;
    public function actionIndex()
    {
//        var_dump(\Yii::$app->user->isGuest) ;exit;

            $models=GoodsCategory::find()->where(['parent_id'=>0])->all();
            return $this->render('header',['models'=>$models]);


    }

    //商品显示
    public function actionList($id){
        //判断几级
        $model=GoodsCategory::findOne(['id'=>$id]);

        if($model->depth===2){
            $models=Goods::findAll(['goods_category_id'=>$id]);
        }else{
            //第一種
            $cate=GoodsCategory::find()->where("depth=2 AND lft>$model->lft AND rgt<$model->rgt AND tree=$model->tree" )->all();
            $ids=[];
            foreach ($cate as $c){
                $ids[]=$c->id;
            }
            //第二種
//            $ids=GoodsCategory::find()->select('id')->where("depth=2 AND lft>$model->lft AND rgt<$model->rgt AND tree=$model->tree" )->column();
            $models=Goods::find()->where(['in','goods_category_id',$ids])->all();
        }

        return $this->render('list',['models'=>$models]);
    }
    //商品详情显示
    public function actionGoods($id){
        $model=Goods::findOne(['id'=>$id]);
        $pngs=GoodsGallery::findAll(['goods_id'=>$id]);
        $comtent=GoodsIntro::findAll(['goods_id'=>$id]);
//        var_dump($pngs);exit;
        return $this->render('goods',['model'=>$model,'pngs'=>$pngs,'contents'=>$comtent]);
    }



    //添加购物车成功提示页
    public function actionNotice($goods_id,$amount){
        if(\Yii::$app->user->isGuest){
            //未登录，数据保存到cookie中
            $cookies = \Yii::$app->request->cookies;
            //1.看cookie中是否有购物车
            $carts = $cookies->getValue('carts');
            if($carts==null){
                $carts = [];
            }else{
                $carts = unserialize($carts);
            }
            //1.根据goods_id 去购物车表查询，是否存在该商品
            if(array_key_exists($goods_id,$carts)) {
                //1.1如果已存在，则更新购物车对应的商品数量
                $carts[$goods_id] += $amount;
            }else{
                //1.2如果不存在，则插入一条新数据
                $carts[$goods_id] = $amount;
            }
            $cookies = \Yii::$app->response->cookies;
            //写入数据到cookie
            $cookie = new Cookie([
                'name'=>'carts',
                'value'=>serialize($carts),
                'expire'=>time()+30*24*3600 //过期时间戳 30天
            ]);
            $cookies->add($cookie);//设置cookie


        }
            //已登陆,数据保存到数据表
            //1.根据goods_id 和 member_id 去购物车表查询，是否存在该商品
                $member_id=\Yii::$app->user->id;
//            var_dump($member_id);exit;
                $model=Cart::findOne(['member_id'=>$member_id,'goods_id'=>$goods_id]);
                if($model){
                    //1.1如果已存在，则更新购物车对应的商品数量
                    $model->amount+=$amount;
                    $model->save();
                }else{
                    //1.2如果不存在，则插入一条新数据
                    $model=new Cart();
                    $model->goods_id=$goods_id;
                    $model->amount=$amount;
                    $model->member_id=$member_id;
                    $model->save();
//                exit;
                }


        //自动跳转到购物车
        return $this->redirect(['header/cart']);

    }

    public function actionCart(){
        if(\Yii::$app->user->isGuest){
            //未登陆 购物车数据从cookie获取
            $cookies = \Yii::$app->request->cookies;
            //1.看cookie中是否有购物车
            $carts = $cookies->getValue('carts');
            if($carts==null){
                $carts = [];
            }else{
                $carts = unserialize($carts);
            }
            //$carts = [1=>10,3=>20];
        }else{
            //登陆 购物数据从数据库获取
            $member_id=\Yii::$app->user->id;
            $carts=[];
            $models_cart=Cart::find()->where(['member_id'=>$member_id])->all();
            foreach ($models_cart as $v){
                $carts[$v->goods_id]=$v->amount;
            }

        }
        $models = Goods::find()->where(['in','id',array_keys($carts)])->all();
        return $this->render('cart',['models'=>$models,'carts'=>$carts]);
    }

    //ajax
    public function actionAjaxCart(){
        if(\Yii::$app->user->isGuest){
            //修改cookie中的购物车  goods_id  amount
            $goods_id =\Yii::$app->request->post('goods_id');
            $amount = \Yii::$app->request->post('amount');

            $cookies = \Yii::$app->request->cookies;
            //1.看cookie中是否有购物车
            $carts = $cookies->getValue('carts');
            if($carts==null){
//                $carts = [];
                return '商品不存在，请刷新页面';
            }else{
                $carts = unserialize($carts);
            }
            //1.根据goods_id 去购物车表查询，是否存在该商品
            if(array_key_exists($goods_id,$carts)) {
                //1.1如果已存在，则更新购物车对应的商品数量
                if($amount==0){
                    //删除
                    unset($carts[$goods_id]);
                    echo "delete-success";
                }else{
                    $carts[$goods_id] = $amount;
                }
                $cookies =\Yii::$app->response->cookies;
                //写入数据到cookie
                $cookie = new Cookie([
                    'name'=>'carts',
                    'value'=>serialize($carts),
                    'expire'=>time()+30*24*3600 //过期时间戳 30天
                ]);
                $cookies->add($cookie);//设置cookie
                return 'success';
            }else{
                return '商品不存在，请刷新页面';
            }
        }else{
            $goods_id =\Yii::$app->request->post('goods_id');
            $amount = \Yii::$app->request->post('amount');
            $model=Cart::findOne(['goods_id'=>$goods_id]);
            if($amount==0){
                $model->delete();
            }else{
                $model->amount=$amount;
                $model->save();
                return 'delete-success';
            }

        }
    }

    //订单
    public function actionOrder(){

        if(\Yii::$app->user->isGuest){
            return $this->redirect(['header/cart']);
        }
        //订单显示
        if(!\Yii::$app->request->isPost){
            $member_id=\Yii::$app->user->id;
            //显示地址数据
            $address=Address::findAll(['member_id'=>$member_id]);
            //购物车数据
            $carts=[];
            $models_cart=Cart::find()->where(['member_id'=>$member_id])->all();
            foreach ($models_cart as $v){
                $carts[$v->goods_id]=$v->amount;
            }

            $goods = Goods::find()->where(['in','id',array_keys($carts)])->all();


            return $this->render('order',['address'=>$address,'goods'=>$goods,'carts'=>$carts]);
        }
        //提交订单
        //流程
        //1 开启事务
        //Yii::$app->db->createCommand('开启事务sql')->execute();
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            //创建订单
            $order=new Order();
            //收货人信息
            $address=Address::findOne(['id'=>\Yii::$app->request->post('address_id')]);
            $order->member_id=$address->member_id;
            $order->name = $address->name;
            $order->province = $address->four;
            $order->city = $address->distri;
            $order->area = $address->xian;
            $order->address=$address->addr;
            $order->tel=$address->tel;
            //送货方式
            $order->delivery_id =\Yii::$app->request->post('delivery_id');
            $order->delivery_name = Order::$deliveries[$order->delivery_id][0];
            $order->delivery_price = Order::$deliveries[$order->delivery_id][1];
            //支付方式
            $order->payment_id =\Yii::$app->request->post('pay_id');
            $order->payment_name = Order::$pays[$order->payment_id][0];
            //时间
            $order->create_time=time();
            if($order->validate()){
                //保存订单
                $order->save();
            }else{
                //提示错误信息
                var_dump($order->getErrors());exit;
            }

            //依次检查购物车的商品库存
            $carts=Cart::findAll(['member_id'=>\Yii::$app->user->id]);
//            var_dump($carts);exit;
            foreach ($carts as $cart){
                //检查该商品库存是否足够 $cart=[goods_id=>1,amount=>22];
                //获取商品表中对应商品的库存

                $goods = Goods::findOne(['id'=>$cart->goods_id]);
                if($goods->stock < $cart->amount){
                    //抛出异常
                    throw new Exception('商品库存不足，请返回购物车修改');
                }
                //库存足够，扣减库存，生成订单商品详情数据
                //创建订单详情表记录
                $order_goods=new OrderGoods();
                $order_goods->order_id=$order->id;
                $order_goods->goods_id=$cart->goods_id;
                $order_goods->goods_name=$goods->name;
                $order_goods->logo=$goods->logo;
                $order_goods->price=$goods->shop_price;
                $order_goods->amount=$cart->amount;
                $order_goods->total=$goods->shop_price*$cart->amount;
                if($order_goods->validate()){
                    $order_goods->save();

                    //扣减库存
                    Goods::updateAllCounters(['stock'=>-$cart->amount],['id'=>$cart->goods_id]);
                    //清除购物车
                    Cart::findOne(['member_id'=>\Yii::$app->user->id])->delete();
                }else{
                    //提示错误信息
                    var_dump($order_goods->getErrors());exit;
                }
            }
            //提交事务
            $transaction->commit();
            //跳转到订单提交成功页面
            $order_goods=OrderGoods::findAll(['order_id'=>$order->id]);
            $order=Order::findOne(['id'=>$order->id]);
            return $this->render('order1',['order_goods'=>$order_goods,'order'=>$order]);

        }catch (Exception $e){
            //如果不够回滚
            $transaction->rollBack();
        }
    }



}
