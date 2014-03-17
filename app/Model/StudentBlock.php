<?php

class StudentBlock extends AppModel {

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