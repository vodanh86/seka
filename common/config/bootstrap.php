<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

Yii::setAlias('frontendWebroot', 'http://boxuvietnam.com/seka/frontend/web');
Yii::setAlias('backendWebroot', 'http://boxuvietnam.com/seka/backend/web');