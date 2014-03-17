<?php
/**
*@copyright Copyright (c) 2013 mrhieusd
*/
class StudentController extends AppController {
	/**
	* index
	*/
	public $uses = array('User', 'StudentHistory', 'Lesson','Category','Test','Tag','Quest','Answer');
	function beforeFilter() {
        $this->pageTitle = 'Home Student';
        $this->layout = 'template';
        $UserType = $this->Auth->user('UserType');
         if($UserType == 2){
        	$this->redirect(array('controller'=>'Teacher','action' => 'index'));
        }else if($UserType == 3){
        	$this->redirect(array('controller'=>'Admin','action' => 'home'));
        }else{
        	
        }
        return parent::beforeFilter();
    }
	public function index() {
		$this->pageTitle = 'Home of Student';
        $this->StudentHistory->recursive = -1;
        
        $userId = $this->Auth->user('UserId');
        if (isset($this->request->query['sortBy'])) {
            $sortBy = $this->request->query['sortBy'];
        } else {
            $sortBy = 'time';
        }
        $options = $this->StudentHistory->getPaginationOptions($userId, $sortBy);
        
        $this->paginate = $options;
        $histories = $this->paginate('StudentHistory');
        $this->set('histories', $histories);
         // debug($cat);
        $cat = $this->Category->getCategories();
        $Category = array();
        foreach ($cat as $key => $value) {
        	$Category[$key+1] = $value['Category']['CatName'];
        }
        //debug($Category);
        $this->set('Category', $Category);
        $allLessons = $this->Lesson->getAllLessons();
//	    debug($allLessons);
        $this->set('allLessons', $allLessons);
	}
	public function view_lesson() {
		$this->pageTitle = 'View Lesson';
	}
	public function test($lesson_id =null) {
		// $this->pageTitle = 'テスト';
		// $userId = $this->Auth->user('UserId');
		// if(!isset($lesson_id)||empty($lesson_id)){
		// 	$this->redirect(array('controller'=>'Teacher','action' => 'index'));
		// }else{
		// 	$this->set(compact('lesson_id'));
		// 	$test = $this->Test->find('all', array(
		// 		'conditions'=>array(
		// 			'Test.LessonId'=>$lesson_id,
		// 			'IsDeleted'=>'0',
		// 			),
		// 		'order' => array('Test.TestId' => 'Asc'),
		// 		)
		// 	);
		// 	// debug($test);
		// 	$data_test = array();
		// 	foreach ($test as $key => $value) {
		// 		$data_test['Title'] = $value['Test']['Title'];
		// 		$data_test['SubTitle'] = $value['Test']['SubTitle'];
		// 		if(isset($value['Question'])&&!empty($value['Question'])){
		// 			$i=0;
		// 			$j=0;
		// 			foreach ($value['Question'] as $key => $value) {
		// 				$i++;
		// 				$data_test['Question'][$i]['Content'] = $value['QuesContent'];
		// 				$data_test['Question'][$i]['QuesNum'] = $value['QuesNumber'];
		// 				$j = $j+$value['Point'];
		// 				$tmp = strstr($value['QuesAnswer'], ')', true);
		// 				$tmp = substr($tmp,2);
		// 				$tmp = (int)$tmp;
		// 				$data_test['Question'][$i]['Answer'] = $tmp;
		// 				$data_test['Question'][$i]['Point'] = $value['Point'];	
		// 				$data_test['Question'][$i]['An'] = $this->Answer->find('all',array(
		// 					'conditions' => array('Answer.QuesId' =>$value['QuesId']),
		// 					'order' => array('Answer.AnswerNumber' => 'Asc'),
		// 					)
		// 				);		
		// 			}
		// 			$data_test['Total'] = $i;
		// 			$data_test['TotalPoint'] = $j;
		// 		}
		// 	}
		// 	$this->set(compact('data_test'));
		// 	// debug($data_test);
		// }
	}
	public function view_result() {
		$this->pageTitle = 'View Test Result';
	}
	public function review_test() {
		$this->pageTitle = 'Review Test';
	}
	public function transaction_history($id = null) {        
        $this->pageTitle = 'Transaction History';
        if (isset($this->request->data['months']) && isset($this->request->data['year'])) {
            $month = $this->request->data['months'];
            $year = $this->request->data['year'];
        } else {
            $month = 0;
            $year = 0;
        }

        $transactions = $this->StudentHistory->getStudentTransactionHistory($this->Auth->user('UserId'), $month, $year);
        $this->set('transactions', $transactions);
        $total = 0;
        foreach ($transactions as $t) {
            $total = $total + $t['StudentHistory']['CourseFee'];
        }
        $this->set('Total', $total);
    }
    public function view_category($catId) {
        $category = $this->Category->getCategory($catId);
        $this->set('cat', $category);
        
        $options = $this->Category->getPaginationOptions($catId);
        
        $this->paginate = $options;
        $lessons = $this->paginate('Category');
        $this->set('lessons', $lessons);
    }
	public function buy_lesson() {
	}

}	
?>