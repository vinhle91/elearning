<?php
App::uses('AuthComponent', 'Controller/Component');
class File extends AppModel {
    public $uses = array('Lesson');
    public $primaryKey = 'FileId';
    public $belongsTo = array(
        'Lesson' => array(
            'className' => 'Lesson',
            'foreignKey' => 'LessonId',
        ),
    );
    public $actsAs = array(
        'Uploader.Attachment' => array(
            'File' => array(
                // 'nameCallback' => 'formatName',
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
}

?>