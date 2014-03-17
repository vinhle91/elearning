<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lesson
 *
 * @author anh
 */
class Question extends AppModel{
	public $primaryKey = 'QuesId';
    //put your code here
    public $hasMany = array(
        'Answer' => array(
            'className' => 'Answer',
            'foreignKey' => 'QuesId',
            'order' => 'Answer.AnswerNumber Asc',
            'dependent' => true
        ),
    );          
        
}
