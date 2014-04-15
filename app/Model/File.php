<?php
App::uses('AuthComponent', 'Controller/Component');
class File extends AppModel {
    public $uses = array('Lesson');
    public $primaryKey = 'FileId';
    public $actsAs = array(
        'Uploader.Attachment' => array(
            'File' => array(
                'nameCallback' => 'formatName',
                'overwrite' => false,
                'uploadDir' => 'uploads/jugyou',
                'finalPath' => '',
                'size' => 'fileSize',
                'allowEmpty' => false,
                'dbColumn' => 'FileLink',
                'metaColumns' => array(
                    'ext' => 'Extension',
                )
            ),
            'TestFile' => array(
                // 'nameCallback' => 'formatName',
                'overwrite' => false,
                'allowEmpty' => true,
                'uploadDir' => 'uploads/tsv',
                'finalPath' => '',
                'size' => 'fileSize',
                'dbColumn' => 'FileLink',
                'metaColumns' => array(
                    'ext' => 'Extension',
                )
            )
        ),
        'Uploader.FileValidation' => array(
            'File' => array(
                'extension' => array('gif', 'jpg', 'png', 'pdf','mp3','mp4','wav','tsv'),
                'filesize' => 52428800,
                'required' => array(
                    'value' => true,
                    'error' => 'File required',
                )
            ),
            'TestFile' => array(
                'extension' => array('tsv'),
                'filesize' => 52428800,
                'required' => array(
                    'value' => true,
                    'error' => 'File required',
                )
            )
        )
    );
    public function formatName($name, $file) {
        // $userId = $this->Auth->user('UserId');
        // // Get lesson id
        // $lesson= $this->Lesson->find('first', array(
        //      'conditions' => array('Lesson.UserId' => $userId),
        //      'fields' => array('Lesson.LessonId','Lesson.created'),
        //      'order' => array('Lesson.created' => 'desc'),
        //      'contain'=> False,
        // ));
        // $lesson_id = $lesson['Lesson']['LessonId'];
        // $date = $lesson['Lesson']['created'];
        // $date = date_format($date, 'Y-m-d');

        // if ($lesson_id) {
        //     sprintf('%s-%s-%s-%s', $lesson_id,$date, $file->size(), $file->ext());
        // }
        // return $name;
        return sprintf('%s-%s', $name, $file->size());
    }
    // public function beforeUpload($options) {
    //     $options['uploadDir'] = WWW_ROOT . $options['finalPath'];         
    //     return $options;
    
}

?>