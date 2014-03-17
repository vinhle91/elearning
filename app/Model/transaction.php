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
			)
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
			$data = $this->find("all", array(
					'recursive' => '2',
					'conditions' => $condition,
				));

			$tt_trans = $this->find("count", array(
					'conditions' => $condition,
					));


			$tt_student = $tt_student = $this->find("count", array(
					'fields' => 'DISTINCT Transaction.UserId',
					'conditions' => $condition,
				));

			$options['conditions'] = $condition;

			$options['fields'] = 'DISTINCT Lesson.UserId';

			$tt_teacher = $this->find('count', $options);

			$buff = array(
				'Total' => $tt_trans,
				'TotalStudent' => $tt_student,
				'TotalTeacher' => $tt_teacher,
				'Data' => $data,
				);

			return $buff;

		}

		if ($param == "LastWeek") {
			$condition = array(
				'StartDate >' => date('Y-m-d',strtotime("-1 weeks")),
				'Blocked' => '0'
				);
			$data = $this->find("all", array(
					'recursive' => '2',
					'conditions' => $condition,
				));

			$tt_trans = $this->find("count", array(
					'conditions' => $condition,
					));


			$tt_student = $tt_student = $this->find("count", array(
					'fields' => 'DISTINCT Transaction.UserId',
					'conditions' => $condition,
				));

			$options['conditions'] = $condition;

			$options['fields'] = 'DISTINCT Lesson.UserId';

			$tt_teacher = $this->find('count', $options);

			$buff = array(
				'Total' => $tt_trans,
				'TotalStudent' => $tt_student,
				'TotalTeacher' => $tt_teacher,
				'Data' => $data,
				);

			return $buff;

		}

		if ($param == "LastMonth") {
			$condition = array(
				'StartDate >' => date('Y-m-d',strtotime("-1 months")),
				'Blocked' => '0'
				);
			$data = $this->find("all", array(
					'recursive' => '2',
					'conditions' => $condition,
				));

			$tt_trans = $this->find("count", array(
					'conditions' => $condition,
					));


			$tt_student = $tt_student = $this->find("count", array(
					'fields' => 'DISTINCT Transaction.UserId',
					'conditions' => $condition,
				));

			$options['conditions'] = $condition;

			$options['fields'] = 'DISTINCT Lesson.UserId';

			$tt_teacher = $this->find('count', $options);

			$buff = array(
				'Total' => $tt_trans,
				'TotalStudent' => $tt_student,
				'TotalTeacher' => $tt_teacher,
				'Data' => $data,
				);

			return $buff;

		}

		if ($param == "All") {
			$condition = array(
				'Blocked' => '0'
				);
			$data = $this->find("all", array(
					'recursive' => '2',
					'conditions' => $condition,
				));

			$tt_trans = $this->find("count", array(
					'conditions' => $condition,
					));


			$tt_student = $tt_student = $this->find("count", array(
					'fields' => 'DISTINCT Transaction.UserId',
					'conditions' => $condition,
				));

			$options['conditions'] = $condition;

			$options['fields'] = 'DISTINCT Lesson.UserId';

			$tt_teacher = $this->find('count', $options);

			$buff = array(
				'Total' => $tt_trans,
				'TotalStudent' => $tt_student,
				'TotalTeacher' => $tt_teacher,
				'Data' => $data,
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

		$data = $this->find("all", $options);

		$tt_trans = $this->find("count", $options);	

		$tt_student = $this->find("count", array(
				'fields' => 'DISTINCT Transaction.UserId',
				'conditions' => $options['conditions'],
			));

		$tt_teacher = $this->find("count", array(
				'fields' => 'DISTINCT Lesson.UserId',
				'conditions' => $options['conditions'],
			));

		$buff = array(
			'Total' => $tt_trans,
			'TotalStudent' => $tt_student,
			'TotalTeacher' => $tt_teacher,
			'Data' => $data,
			);

		return $buff;
	}
}
?>