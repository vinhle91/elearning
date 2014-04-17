<?php
class Msg extends AppModel {
    public $useTable = "msgs";
    public $primaryKey = "MsgId";

    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'UserId',
            'fields' => array(
                'User.UserId',
                'User.Username',
                'User.Status',
                'User.UserType'
            )
        ),
    );
}?>