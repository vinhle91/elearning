<?php
class ReadtsvComponent extends Component {

	/**
    * Holds the parsed result
    * 
    * @access   private
    * @var      array
    */
    protected $table_arr;
    protected $delimiter = "\t";
    
    /**
    * Defines valid file extension
    * 
    * @access   protected
    * @var      string
    */
    protected $file_extension = 'tsv';
    public function loadFile($file_path){
	
		if (!$this->isFileReady($file_path)) {
			return;
		}

		$this->loadString(file_get_contents($file_path));
	}
	
	/**
	* Load the string to be parsed
	* 
	* @param    string  $str    String with CSV format
	*/
	public function loadString($str){
		$this->table_arr = array();
		
	// 1. Split into lines by newline http://stackoverflow.com/questions/3997336/explode-php-string-by-new-line 
		$pattern = "/\r\n|\n|\r/";
		$lines   = preg_split($pattern, $str, -1, PREG_SPLIT_NO_EMPTY);
		$total   = count($lines);
		
		// There are no lines to parse
		if ($total == 0) {
			return;
		}
		
		// 2. Guess delimiter if none set
		$line = $lines[0];
		if (!isset($this->delimiter)) {
			// do guess work
			$separators = array(';' => 0, ',' => 0);
			foreach ($separators as $sep => $count) {
				$args  = str_getcsv($sep, $line);
				$count = count($args);
				
				$separators[$sep] = $count;
			}
			
			$sep = ',';
			if (($separators[';'] > $separators[','])) {
				$sep = ';';
			}
			
			$this->delimiter = $sep;
		}
		
		// 3. Parse the lines into rows,cols
		$max  = 0;
		$min  = PHP_INT_MAX;
		$cols = 0;
		$sep  = $this->delimiter;
		$rows = array(); 
		foreach ($lines as $line) {
			$args   = str_getcsv($line, $sep);
			$rows[] = $args;
			
			$cols = count($args);
			if ($cols > $max) {
				$max = $cols;
			}
			if ($cols < $min) {
				$min = $cols;
			}
		}
		
		// 4. Expand those rows which have less cols than max cols found
		if ($min != $max) {
			foreach ($rows as $i => $row) {
				$c = count($row);
				while ($c < $max) {
					$row[] = ""; // fill with empty strings
					$c += 1;
				}
				$rows[$i] = $row;
			}
		}
		$this->table_arr = $rows;
	}
	
	/**
	* Set delimiter that should be used to parse CSV document
	* 
	* @param    string  $delimiter   Delimiter character
	*/
	public function setDelimiter($delimiter){
		$this->delimiter = $delimiter;
	}

	/**
    * Get value of the specified cell
    * 
    * @param    int $row_num    Row number
    * @param    int $col_num    Column number
    * @param    int $val_only
    * @return   array
    * @throws   Exception       If the cell identified doesn't exist.
    */
    public function getCell($row_num, $col_num, $val_only = true) {
        // check whether the cell exists
        if (!$this->isCellExists($row_num, $col_num)) {
        	$error ='CELL_NOT_FOUND ';
 			return $error;
        }
        return $this->table_arr[$row_num-1][$col_num-1];
    }

    /**
    * Get data of the specified column as an array
    * 
    * @param    int     $col_num    Column number
    * @param    bool    $val_only
    * @return   array
    * @throws   Exception           If the column requested doesn't exist.
    */
    public function getColumn($col_num, $val_only = TRUE) {
        $col_arr = array();

        if(!$this->isColumnExists($col_num)){
           $error ='COLUM_NOT_FOUND ';
 			return $error;
        }

        // get the specified column within every row
        foreach($this->table_arr as $row){
            array_push($col_arr, $row[$col_num-1]);
        }

        // return the array
        return $col_arr;
    }

 
    public function getField($val_only = TRUE) {
        if(!$this->isFieldExists()){
            $error ='FIELD_NOT_FOUND ';
 			return $error;
        }
        
        // return the array
        return $this->table_arr;
    }


    public function getRow($row_num, $val_only = TRUE) {
        if(!$this->isRowExists($row_num)){
           $error ='ROW_NOT_FOUND ';
 			return $error;
 		}

        // return the array
        return $this->table_arr[$row_num-1];
    }

 	public function isColumnExists($col_num){
        $exist = false;
        foreach($this->table_arr as $row){
            if(array_key_exists($col_num-1, $row)){
                $exist = true;
            }
        }
        return $exist;
    }
    
    public function isRowExists($row_num){
        return array_key_exists($row_num-1, $this->table_arr);
    }
    
    public function isCellExists($row_num, $col_num) {
        return $this->isRowExists($row_num) && $this->isColumnExists($col_num);
    }
    
  
    
    /**
    * Check whether table exists
    * 
    * @return   bool
    */
    public function isFieldExists(){
        return isset($this->table_arr);
    }
    
    /**
    * Check whether file exists, valid, and readable
    * 
    * @param    string  $file_path  Path to file
    * @return   bool
    * @throws   Exception           If file being loaded doesn't exist
    * @throws   Exception           If file extension doesn't match
    * @throws   Exception           If error reading the file
    */
    public function isFileReady($file_path) {
    
    //     // file exists?
    //     if (!file_exists($file_path)) {
        
    //         $error ='FILE_NOT_FOUND ';
        
    //     // extension valid?
    //     } else if (strtoupper(pathinfo($file_path, PATHINFO_EXTENSION))!= strtoupper($this->file_extension)){

    //          $error ='FILE_EXTENSION_MISMATCH ';
        
    //     // file readable?
    //     } else if (($handle = fopen($file_path, 'r')) === FALSE) {            
    //     	$error ='ERROR_READING_FILE ';
 			// fclose($handle);; 

    //     // okay then
    //     } else {
            
            return TRUE;
        
    }

}

?>