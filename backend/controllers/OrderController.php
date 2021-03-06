<?php

namespace backend\controllers;

use Yii;
use kartik\mpdf\Pdf;
use common\models\Order;
use common\models\OrderItem;
use common\models\User;
use backend\models\OrderSearch;
use backend\models\OrderItemSearch;
use yii\web\Controller;
use yii2tech\spreadsheet\Spreadsheet;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use cakebake\actionlog\model\ActionLog;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper; 
/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
		    'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
						'matchCallback' => function ($rule, $action) {
                            return \common\models\User::isUserAdmin(Yii::$app->user->identity->username);
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionPdf($id){
        $model = $this->findModel($id);
        $items = OrderItem::find()->where(['order_id' => $id])->all();

        $content = $this->renderPartial('pdf', ['model1' => $model,
            'items' => $items]);
    
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            //'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}', 
            // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
            // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>['Hoá đơn Seka'], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        
        // return the pdf output as per the destination setting
        return $pdf->render(); 
    }

    public function actionExport()
    {
        $searchModel = new OrderSearch();
        $searchModel->load(Yii::$app->request->post());
        $prodQuery = $this->getQuery($searchModel);
        $orders = array();
        $order_status = array(
            \common\models\Order::STATUS_NEW => 'Mới', 
            \common\models\Order::STATUS_WAIT_CONFIRM => 'Chờ xác nhận',
            \common\models\Order::STATUS_CONFIRM => 'Đã xác nhận', 
            \common\models\Order::STATUS_ORDER => 'Đã order',
            \common\models\Order::STATUS_CHINA_STORE => 'Hàng về kho Trung Quốc', 
            \common\models\Order::STATUS_VIETNAM_STORE => 'Hàng về kho Việt Nam',
            \common\models\Order::STATUS_PARTIAL_SHIP => 'Hàng giao 1 phần', 
            \common\models\Order::STATUS_SHIP => 'Hàng đã giao',   
            \common\models\Order::STATUS_BILL => 'Đã xuất hoá đơn', 
            \common\models\Order::STATUS_CANCEL => 'Đã huỷ đơn',
        );
        $users = ArrayHelper::map(User::find()->all(), 'id', 'username');
        $payment = array(Order::PAYMENT_CASH, Order::PAYMENT_TRANSFER, Order::PAYMENT_COD_GHTK, Order::PAYMENT_CODE_SHOPEE);
        foreach( $prodQuery->all() as $order){
            array_push($orders, array("id" => $order->id, "created_at" => date('d M Y H:i:s',$order->created_at),
            "updated_at" => date('d M Y H:i:s',$order->updated_at), "surname" => $order->surname,
            "name" => $order->name, "country" => $order->country,
            "region" => $order->region, "city" => $order->city,
            "address" => $order->address, "zip_code" => $order->zip_code,
            "phone" => $order->phone, "email" => $order->email,
            "notes" => $order->notes, "status" => $order_status[$order->status],
            "user" => isset($order->user_id) ? $users[$order->user_id] : "",
           // 'payment_method' => in_array($order->payment_method, $payment) ? $order->payment_method: $order->other_payment_method,
            'payment_method' => $order->payment_method
        ));
        }

        $exporter = new Spreadsheet([
            'dataProvider' => new ArrayDataProvider([
                'allModels' => $orders
            ]),
        ]);
        return $exporter->send('items.xls');
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function getQuery($searchModel){
        $prodQuery = Order::find()->where(['not',['id'=>0]]);
                  //global search
		if($surname = $searchModel->surname){
		    $prodQuery->andFilterWhere(['user_id' => $surname]);
		}

		if($name = $searchModel->name){
            $userQuery = User::find()->where(['supporter'=>$name]);
            $list = array();
            foreach($userQuery->all() as $user) {
                array_push($list, $user->id);
            };
            if (count($list) > 0){
                $prodQuery->andFilterWhere(['in', 'user_id', $list]);
            } else {
                $prodQuery->andFilterWhere(['user_id' => 0]);
            }
   
		}
  
		if($country = $searchModel->country){
		    $prodQuery->joinWith('orderItems', false)->where(["product_id" => $country]);
		}

		if($status = $searchModel->status){
            $prodQuery->andFilterWhere(['status' => $status]);
		}

		if($payment_method = $searchModel->payment_method){
            if ($payment_method != "Khác"){
                $prodQuery->andFilterWhere(['like', 'payment_method', $payment_method]);
            } else {
                $prodQuery->andFilterWhere(['not in', 'payment_method', [Order::PAYMENT_CASH, Order::PAYMENT_TRANSFER, Order::PAYMENT_COD_GHTK, Order::PAYMENT_CODE_SHOPEE]]);
            }
        }
        return $prodQuery;
    }
        /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionReport()
    {

        $searchModel = new OrderSearch();
        $searchModel->load(Yii::$app->request->post());

        if(Yii::$app->request->post('submit') == 'export'){
            return $this->actionExport();
        }

        $prodQuery = $this->getQuery($searchModel);
 
        $dataProvider = new ActiveDataProvider([
            'query' => $prodQuery
        ]); 
        return $this->render('report', [
            'model' => $searchModel,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$searchModelItem = new OrderItemSearch(['order_id' => $id]);
        $dataProviderItem = $searchModelItem->search(Yii::$app->request->queryParams);
		
        return $this->render('view', [
            'model1' => $this->findModel($id),
			'searchModelItem' => $searchModelItem,
			'dataProviderItem' => $dataProviderItem,
        ]);
    }

    

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())){
            if ($model->other_payment_method){
                $model->payment_method = $model->other_payment_method;
            }
            if ($model->save()) {
                ActionLog::add('update order', Yii::$app->user->identity->username);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        ActionLog::add('delete order', Yii::$app->user->identity->username);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
