<?php
namespace common\models;

class ProductSearchForm extends \yii\base\Model
{
    public $title;
    public $description;
    public $created_at;
    public $updated_at;

    public function rules()
    {
        return [
            // define validation rules here
        ];
    }
}