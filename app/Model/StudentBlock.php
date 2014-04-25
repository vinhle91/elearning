<?php

class StudentBlock extends AppModel {
	// public $primaryKey = array('UserId','LessonId');

	function getStudentBlockByUserIdAndLessonId($userId, $lessonId)
    {
        $options['conditions'] = array(
                'StudentBlock.LessonId' => $lessonId,
                'StudentBlock.UserId' => $userId
            );
   
        return $studentBlocks = $this->find('all', $options);
    }
}

?>