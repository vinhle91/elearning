<?php 
class Transaction extends AppModel {
	public $useTable = 'student_histories';
	public $name = 'Transaction';

	public $belongsTo = array(
		'Lesson' => array(
			'className' => 'Lesson',
			'foreignKey' => 'LessonId',
			// 'foreignKey' => false,
			'fields' => array(
				'Lesson.LessonId',
				'Lesson.Title',
				'Lesson.UserId'
				),
			// 'conditions' => array("`Transaction`.`LessonId` = `Lesson`.`LessonId`"),
			),
		'Student' => array(
			'className' => 'User',
			'foreignKey' => 'UserId',
			'fields' => array(
				'Student.UserId',
				'Student.Username',
				'Student.Status',
				)
			),
		);


	public function getTransactions($param) {
		$fields = array(
			// 'UserId',
			// 'LessonId',
			// 'StartDate',
			'ExpiryDate',
			'CourseFee',
			// 'IsLike',
			// 'Blocked',
			);
		if ($param == "Today") {
			$condition = array(
				'StartDate >' => date('Y-m-d',strtotime("-1 days")),
				'Blocked' => '0'
				);
			$_data = $this->find("all", array(
					'recursive' => '2',
					'conditions' => $condition,
				));

			$_amount = $this->find("count", array(
					'conditions' => $condition,
					));


			$_student = $_student = $this->find("count", array(
					'fields' => 'DISTINCT Transaction.UserId',
					'conditions' => $condition,
				));

			$_start = $this->find("all", array(
					'conditions' => $condition,
					'fields' => 'StartDate',
					'order' => 'StartDate ASC',
					'limit' => '1'
				));
			if ($_start)
				$_start = $_start[0]['Transaction']['StartDate'];

			$_end = $this->find("all", array(
					'conditions' => $condition,
					'fields' => 'StartDate',
					'order' => 'StartDate DESC',
					'limit' => '1'
				));
			if ($_end) 
				$_end = $_end[0]['Transaction']['StartDate'];

			$options['conditions'] = $condition;

			$options['fields'] = 'DISTINCT Lesson.UserId';

			$_teacher = $this->find('count', $options);

			$buff = array(
				'Start' => $_start,
				'End' => $_end,
				'Total' => $_amount,
				'TotalStudent' => $_student,
				'TotalTeacher' => $_teacher,
				'Data' => $_data,
				);

			return $buff;

		}

		if ($param == "LastWeek") {
			$condition = array(
				'StartDate >' => date('Y-m-d', strtotime('-'.date('w').' days')),
				'Blocked' => '0'
				);
			$_data = $this->find("all", array(
					'recursive' => '2',
					'conditions' => $condition,
				));

			$_amount = $this->find("count", array(
					'conditions' => $condition,
					));


			$_student = $_student = $this->find("count", array(
					'fields' => 'DISTINCT Transaction.UserId',
					'conditions' => $condition,
				));

			$_start = $this->find("all", array(
					'conditions' => $condition,
					'fields' => 'StartDate',
					'order' => 'StartDate ASC',
					'limit' => '1'
				));
			if ($_start)
				$_start = $_start[0]['Transaction']['StartDate'];

			$_end = $this->find("all", array(
					'conditions' => $condition,
					'fields' => 'StartDate',
					'order' => 'StartDate DESC',
					'limit' => '1'
				));
			if ($_end) 
				$_end = $_end[0]['Transaction']['StartDate'];

			$options['conditions'] = $condition;

			$options['fields'] = 'DISTINCT Lesson.UserId';

			$_teacher = $this->find('count', $options);

			$buff = array(
				'Start' => $_start,
				'End' => $_end,
				'Total' => $_amount,
				'TotalStudent' => $_student,
				'TotalTeacher' => $_teacher,
				'Data' => $_data,
				);

			return $buff;

		}

		if ($param == "LastMonth") {
			$condition = array(
				'StartDate >=' => date('Y-m-01'),
				'Blocked' => '0'
				);
			$_data = $this->find("all", array(
					'recursive' => '2',
					'conditions' => $condition,
				));

			$_amount = $this->find("count", array(
					'conditions' => $condition,
					));


			$_student = $_student = $this->find("count", array(
					'fields' => 'DISTINCT Transaction.UserId',
					'conditions' => $condition,
				));

			$_start = $this->find("all", array(
					'conditions' => $condition,
					'fields' => 'StartDate',
					'order' => 'StartDate ASC',
					'limit' => '1'
				));
			if ($_start)
				$_start = $_start[0]['Transaction']['StartDate'];

			$_end = $this->find("all", array(
					'conditions' => $condition,
					'fields' => 'StartDate',
					'order' => 'StartDate DESC',
					'limit' => '1'
				));
			if ($_end) 
				$_end = $_end[0]['Transaction']['StartDate'];

			$options['conditions'] = $condition;

			$options['fields'] = 'DISTINCT Lesson.UserId';

			$_teacher = $this->find('count', $options);

			$buff = array(
				'Start' => $_start,
				'End' => $_end,
				'Total' => $_amount,
				'TotalStudent' => $_student,
				'TotalTeacher' => $_teacher,
				'Data' => $_data,
				);

			return $buff;

		}

		if ($param == "All") {
			$condition = array(
				'Blocked' => '0'
				);
			$_data = $this->find("all", array(
					'recursive' => '2',
					'conditions' => $condition,
				));

			$_amount = $this->find("count", array(
					'conditions' => $condition,
					));


			$_student = $_student = $this->find("count", array(
					'fields' => 'DISTINCT Transaction.UserId',
					'conditions' => $condition,
				));

			$_start = $this->find("all", array(
					'conditions' => $condition,
					'fields' => 'StartDate',
					'order' => 'StartDate ASC',
					'limit' => '1'
				));
			if ($_start)
				$_start = $_start[0]['Transaction']['StartDate'];

			$_end = $this->find("all", array(
					'conditions' => $condition,
					'fields' => 'StartDate',
					'order' => 'StartDate DESC',
					'limit' => '1'
				));
			if ($_end) 
				$_end = $_end[0]['Transaction']['StartDate'];

			$options['conditions'] = $condition;

			$options['fields'] = 'DISTINCT Lesson.UserId';

			$_teacher = $this->find('count', $options);

			$buff = array(
				'Start' => $_start,
				'End' => $_end,
				'Total' => $_amount,
				'TotalStudent' => $_student,
				'TotalTeacher' => $_teacher,
				'Data' => $_data,
				);

			return $buff;
		}
		
	}

	public function getUserTransaction($userId, $month, $year) {
		$options['conditions'] = array(
				'Transaction.UserId' => $userId,
				'Blocked' => '0',
				'MONTH(StartDate)' => $month,
				'YEAR(StartDate)' => $year,
			);

		$options['fields'] = '';

		$buff = $this->find("all", $options);
		return $buff;
	}

	public function getTransaction($month, $year) {
		$options['conditions'] = array(
			'Blocked' => '0',
			'MONTH(StartDate)' => $month,
			'YEAR(StartDate)' => $year,
			);

		$_data = $this->find("all", $options);

		$_amount = $this->find("count", $options);	

		$_student = $this->find("count", array(
				'fields' => 'DISTINCT Transaction.UserId',
				'conditions' => $options['conditions'],
			));

		$_teacher = $this->find("count", array(
				'fields' => 'DISTINCT Lesson.UserId',
				'conditions' => $options['conditions'],
			));

		$buff = array(
			'Total' => $_amount,
			'TotalStudent' => $_student,
			'TotalTeacher' => $_teacher,
			'Data' => $_data,
			);

		return $buff;
	}
}
?>