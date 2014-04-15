<?php
App::uses('AuthComponent', 'Controller/Component');
class User extends AppModel {
    public $useTable = "users";
    public $primaryKey = 'UserId';
    public $hasMany = array(
        'Lesson' => array(
            'className' => 'Lesson',
            'foreignKey' => 'UserId',
            'conditions' => array('Lesson.IsDeleted' => '0'),
            'order' => 'Lesson.created DESC',
            'dependent' => true,
        ),
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'UserId',
            'conditions' => array('Comment.IsDeleted' => '0'),
            'order' => 'Comment.created DESC',
            'dependent' => true,
        ),
    ); 
    // public $hasAndBelongsToMany = array(
    //     'StudentTest' =>array(
    //         'className' => 'StudentTest',
    //         'joinTable' => 'students_tests',
    //         'foreignKey' => 'UserId',
    //         'associationForeignKey' => 'TestId',
    //         'unique' => true,
    //         'conditions' => '',
    //         'fields' => '',
    //         'order' => '',
    //         'limit' => '',
    //         'offset' => '',
    //         'finderQuery' => '',
    //         'deleteQuery' => '',
    //         'insertQuery' => ''
    //     )
    // );     
   	public $validate = array(
        'Username' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required',
                'allowEmpty' => false
            ),
            'between' => array( 
                'rule' => array('between', 5, 15), 
                'required' => true, 
                'message' => 'Usernames must be between 5 to 15 characters'
            ),
             'unique' => array(
                'rule'    => array('isUniqueUsername'),
                'message' => 'This username is already in use'
            ),
            'alphaNumericDashUnderscore' => array(
                'rule'    => array('alphaNumericDashUnderscore'),
                'message' => 'Username can only be letters, numbers and underscores'
            ),
        ),

        'Password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            ),
            'min_length' => array(
                'rule' => array('minLength', '6'),  
                'message' => 'Password must have a mimimum of 6 characters'
            )
        ),
         
        'PasswordConfirm' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please confirm your password'
            ),
             'equaltofield' => array(
                'rule' => array('equaltofield','Password'),
                'message' => 'Both passwords must match.'
            )
        ),
        'VerifyCodeQuestion' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A verify code question is required'
            ),
        ),
        'VerifyCodeAnswer' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A verify code answer is required'
            ),
        ),
        'FullName' => array(
            'required' => array(
               'rule' => array('notEmpty'),   
                'message' => 'Please provide a full name.'   
            ),
            'between' => array( 
                'rule' => array('between', 6, 60), 
                'message' => 'Fullname must be between 6 to 60 characters'
            )
        ),

        'Email' => array(
            'required' => array(
                'rule' => array('email', true),    
                'message' => 'Please provide a valid email address.'   
            ),
             'unique' => array(
                'rule'    => array('isUniqueEmail'),
                'message' => 'This email is already in use',
            ),
        ),
        // 'role' => array(
        //     'valid' => array(
        //         'rule' => array('inList', array('king', 'queen', 'bishop', 'rook', 'knight', 'pawn')),
        //         'message' => 'Please enter a valid role',
        //         'allowEmpty' => false
        //     )
        // ),
         
        // 'password_update' => array(
        //     'min_length' => array(
        //         'rule' => array('minLength', '6'),   
        //         'message' => 'Password must have a mimimum of 6 characters',
        //         'allowEmpty' => true,
        //         'required' => false
        //     )
        // ),
        // 'password_confirm_update' => array(
        //      'equaltofield' => array(
        //         'rule' => array('equaltofield','password_update'),
        //         'message' => 'Both passwords must match.',
        //         'required' => false,
        //     )
        // )
    );
    /**
     * Before isUniqueUsername
     * @param array $options
     * @return boolean
     */
    function isUniqueUsername($check) {
 
        $username = $this->find(
            'first',
            array(
                'fields' => array(
                    'User.UserId',
                    'User.Username'
                ),
                'conditions' => array(
                    'User.Username' => $check['Username']
                )
            )
        );
 
        if(!empty($username)){
            if($this->data[$this->alias]['UserId'] == $username['User']['UserId']){
                return true; 
            }else{
                return false; 
            }
        }else{
            return true; 
        }
    }
 
    /**
     * Before isUniqueEmail
     * @param array $options
     * @return boolean
     */
    function isUniqueEmail($check) {
 
        $email = $this->find(
            'first',
            array(
                'fields' => array(
                    'User.UserId'
                ),
                'conditions' => array(
                    'User.email' => $check['Email']
                )
            )
        );
 
        if(!empty($email)){
            if($this->data[$this->alias]['UserId'] == $email['User']['UserId']){
                return true; 
            }else{
                return false; 
            }
        }else{
            return true; 
        }
    }
     
    public function alphaNumericDashUnderscore($check) {
        // $data array is passed using the form field name as the key
        // have to extract the value to make the function generic
        $value = array_values($check);
        $value = $value[0];
 
        return preg_match('/^[a-zA-Z0-9_ \-]*$/', $value);
    }
     
    public function equaltofield($check,$otherfield) 
    { 
        //get name of field 
        $fname = ''; 
        foreach ($check as $key => $value){ 
            $fname = $key; 
            break; 
        } 
        return $this->data[$this->name][$otherfield] === $this->data[$this->name][$fname]; 
    } 
 
    /**
     * Before Save
     * @param array $options
     * @return boolean
     */
    public function beforeSave($options = array())
    {
        $userName= $this->data[$this->alias]['Username'];
        debug($userName);
        // hash our password
        if (isset($this->data[$this->alias]['Password'])) {

            $this->data[$this->alias]['Password'] = AuthComponent::password($userName.$this->data[$this->alias]['Password']);
        }

        if (isset($this->data[$this->alias]['InitialPassword'])) {
            $this->data[$this->alias]['InitialPassword'] = AuthComponent::password($userName.$this->data[$this->alias]['InitialPassword']);
        }

        // // if we get a new password, hash it
        // if (isset($this->data[$this->alias]['password_update']) && !empty($this->data[$this->alias]['password_update'])) {
        //     $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password_update']);
        // }

        // fallback to our parent
        return parent::beforeSave($options);
    }

    public function getUserInfo($username) {
        $user = $this->find('first', array(
            'conditions' => array(
                'User.Username' => $username,
            ),
            'fields' => array(
                'UserId',
                'Username',
                'Password',
                'InitialPassword',
                'UserType',
                'FullName',
                'Birthday',
                'VerifyCodeQuestion',
                'InitialCodeQuestion',
                'VerifyCodeAnswer',
                'InitialCodeAnswer',
                'Gender',
                'Address',
                'Phone',
                'Email',
                'ImageProfile',
                'IsOnline',
                'created',
                'modified',
                'Status',
                'Violated',
                'BankInfo',
                'CreditCard',
            )
        ));
        return $user['User'];
    }

    public function addUser($data) {
        $this->create();
        $this->save($data);
    }

    public function getUserByUsername($username) {
        $options['conditions'] = array(
            'User.Username' => $username
        );
   
        $users = $this->find('all', $options);
        return $users[0];
    }
 
}?>
