<?php
App::uses('AuthComponent', 'Controller/Component');
class User extends AppModel
{
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
        'Ip' => array(
            'className' => 'Ip',
            'foreignKey' => 'UserId',
            'dependent' => true,
            )
    );
    public $validate = array(
        'Username' => array(
            'nonEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'ユーザー名が必要です',
                'allowEmpty' => false
            ),
            'between' => array(
                'rule' => array('between', 5, 15),
                'required' => true,
                'message' => 'ユーザー名は5から15文字の間でなければなりません'
            ),
            'unique' => array(
                'rule' => array('isUniqueUsername'),
                'message' => 'このユーザー名は既に使用されています'
            ),
            'alphaNumericDashUnderscore' => array(
                'rule' => array('alphaNumericDashUnderscore'),
                'message' => 'ユーザー名には、文字、数字、および下線を使用でき'
            ),
        ),

        'Password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'パスワードが必要です'
            ),
            'min_length' => array(
                'rule' => array('minLength', '6'),
                'message' => 'パスワードは6文字以上を持っている必要があります'
            )
        ),

        'PasswordConfirm' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'あなたのパスワードを確認してください'
            ),
            'equaltofield' => array(
                'rule' => array('equaltofield', 'Password'),
                'message' => '両方のパスワードが一致する必要があります'
            )
        ),
        'FullName' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => '名前が必要です'
            ),
            'between' => array(
                'rule' => array('between', 6, 60),
                'message' => '名前6から60文字の間でなければなりません'
            )
        ),
    );

    /**
     * Before isUniqueUsername
     * @param array $options
     * @return boolean
     */
    function isUniqueUsername($check)
    {

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

        if (!empty($username)) {
            if ($this->data[$this->alias]['UserId'] == $username['User']['UserId']) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * Before isUniqueEmail
     * @param array $options
     * @return boolean
     */
    function isUniqueEmail($check)
    {

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

        if (!empty($email)) {
            if ($this->data[$this->alias]['UserId'] == $email['User']['UserId']) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function alphaNumericDashUnderscore($check)
    {
        // $data array is passed using the form field name as the key
        // have to extract the value to make the function generic
        $value = array_values($check);
        $value = $value[0];

        return preg_match('/^[a-zA-Z0-9_ \-]*$/', $value);
    }

    public function equaltofield($check, $otherfield)
    {
        //get name of field 
        $fname = '';
        foreach ($check as $key => $value) {
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
        if (isset($this->data[$this->alias]['Username'])) {
            $userName = $this->data[$this->alias]['Username'];
            // debug($userName);
            // hash our password
            if (isset($this->data[$this->alias]['Password'])) {

                $this->data[$this->alias]['Password'] = AuthComponent::password($userName . $this->data[$this->alias]['Password']);
            }

            if (isset($this->data[$this->alias]['InitialPassword'])) {
                $this->data[$this->alias]['InitialPassword'] = AuthComponent::password($userName . $this->data[$this->alias]['InitialPassword']);
            }
        }
        // // if we get a new password, hash it
        // if (isset($this->data[$this->alias]['password_update']) && !empty($this->data[$this->alias]['password_update'])) {
        //     $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password_update']);
        // }

        // fallback to our parent
        return parent::beforeSave($options);
    }

    public function getUserInfo($username)
    {
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

    public function addUser($data)
    {
        $this->create();
        $this->save($data);
    }

    public function getUserByUsername($username)
    {
        $options['conditions'] = array(
            'User.Username' => $username
        );

        $users = $this->find('first', $options);
        return $users;
    }

}

?>
