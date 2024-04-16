<?php


namespace app\controllers;


use Yii;
use yii\web\Controller;
use app\models\IpLocation;
use yii\web\Response;

class IpLocationController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCheckLocation($ip)
    {
        $ipLocation = new IpLocation();
        $ipLocation->ip_address = $ip;

        if ($ipLocation->validate()) {
            // Отправка запроса на внешний сервис и обработка ответа
            $response = file_get_contents('http://www.geoplugin.net/json.gp?ip=' . $ipLocation->ip_address);
            $data = json_decode($response, true);

            if ($data && !isset($data['geoplugin_error'])) {
                // Сохранение данных в базу данных
                $ipLocation->country = $data['geoplugin_countryName'] ?? null;
                $ipLocation->region = $data['geoplugin_region'] ?? null;
                $ipLocation->city = $data['geoplugin_city'] ?? null;
                $ipLocation->save();

                // Возвращение данных в JSON формате
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => true,
                    'data' => $data,
                ];
            } else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'success' => false,
                    'error' => 'Failed to retrieve location data for the IP address.',
                ];
            }
        } else {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'success' => false,
                'error' => 'Invalid IP address.',
            ];
        }
    }
}