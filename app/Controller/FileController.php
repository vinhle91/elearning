<?php
class FileController extends AppController {

	public $name = 'File';
	
	function beforeFilter() {
        $this->pageTitle = 'Upload Files';
        $this->layout = 'template';
        return parent::beforeFilter();
    }
	public function index() {
		if ($this->request->is('post')){
			if ($this->File->save($this->request->data, true)) {
				// Do something
			}	
		}
	}
}
?>