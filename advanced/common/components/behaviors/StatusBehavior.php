<?php

namespace common\components\behaviors;

use yii\base\Behavior;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StatusBehavior
 *
 * @author user1
 */
class StatusBehavior extends Behavior {
    
    public $statusList;
    
    public function events() {
        return [
//            \yii\db\ActiveRecord::EVENT_AFTER_FIND => 'afterFindStatus', // надо создать функцию с таким же именем
        ];
    }


    // возвращяет массив который будет использован в gridView
    public function getStatusList() {
        return $this->statusList;    
    }
    
    public function getStatusName() {
        $list = $this->owner->getStatusList();
        return $list[$this->owner->status_id];
    }  
    
    // Когда сработает событье AFTER_FIND (когда будет происходить выборка из бд когда модель Blog заполнится данными)
    // после этого сделаем что-то - допустим к заголовку добавим Статус
//    public function afterFindStatus($event) {
//        return $this->owner->title .= ': ' . $this->owner->statusName;
//    }
}
