<?php
/**
*@author  Xu Ding
*@email   thedilab@gmail.com
*@website http://www.StarTutorial.com
*@modified by n97xt - https://github.com/n97xt
**/
class Calendar extends Model {
    
   	public $dayLabels = array("Pon","Wt","Śr","Czw","Pt","Sob","Nie");
    
    private $currentYear=0;
    
    private $currentMonth=0;
    
    private $currentDay=0;
    
    private $currentDate=null;
    
    private $daysInMonth=0;
	
    private $naviHref= null;
    
    public function Index() {
        $this->query('SELECT * FROM events');
		$rows = $this->resultSet();
		return $rows;
	}
    
    public function showCalendar($arguments) {
        
        $events = $this->Index();
                
        $year = null;
		$month = null;
        $week = 1;
        
        if(null==$arguments) {
            
            $date = null;
            
        } else {
            
            $date = explode("/", $arguments); 
            
        }
        
		if(null==$year&&!null==($date)){
            
			$year = $date[0];
            
		}else 
            
        if(null==$year){
            
			$year = date("Y",time());	
            
		}			
		
		if(null==$month&&!null==($date)){
            
			$month = $date[1];
            
		}else 
            
        if(null==$month){

			$month = date("m",time());	
            
		}
        
        		
		$this->currentYear = $year;
		
		$this->currentMonth = $month;
		
		$this->daysInMonth = $this->daysInMonth($month,$year);
        								
        $weeksInMonth = $this->weeksInMonth($month,$year);
        // Create weeks in a month
        

        for( $i=0; $i<$weeksInMonth; $i++ ) {
            
            //Create days in a week
            for($j=1;$j<=7;$j++) {
                $days[$week] = $this->showDay($i*7+$j);
                $week++;
            }
        }
        
        $navi = $this->createNavi();
        
        $show = array(
            'content' => $days, 
            'dayLabels' => $this->dayLabels,
            'navi' => $navi,
            'events' => $events
        );
        return $show;
	}
    
private function showDay($cellNumber) { 

		if($this->currentDay==0) {
			
			$firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));
					
			if(intval($cellNumber) == intval($firstDayOfTheWeek)){
				
				$this->currentDay=1;
				
			}
		}
		
	    if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){
	    	
	    	$this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));
            
	    	$cellContent = $this->currentDay;
			
			$this->currentDay++;	
			
		}else{
			
			$this->currentDate = null;

			$cellContent = null;
		}
			
		return array('content' => $cellContent, 'date' => $this->currentDate); 
	}
    
    private function createNavi(){
		
		$nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
		
		$nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
		
		$preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
		
		$preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;
        
        $currentDate = date('Y M', strtotime($this->currentYear.'-'.$this->currentMonth.'-1'));
        
        $currentDate = $this->translateMonth($currentDate); 
        
        
        $navi = array(
            'nextMonth' => $nextMonth,
            'nextYear' => $nextYear,
            'preMonth' => $preMonth,
            'preYear' => $preYear,
            'currentDate' => $currentDate
        );
        
		return $navi;
	}
    
    private function weeksInMonth($month=null,$year=null) {
		
		if( null==($year) ) {
			$year =  date("Y",time());	
		}
		
		if(null==($month)) {
			$month = date("m",time());
		}
		
		// find number of days in this month
		$daysInMonths = $this->daysInMonth($month,$year);
		
		$numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
		
		$monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
		
		$monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));
		
		if($monthEndingDay<$monthStartDay){
			
			$numOfweeks++;
		
		}
		
		return $numOfweeks;
	}

	/**
    * calculate number of days in a particular month
    */
	private function daysInMonth($month=null,$year=null){
		
		if(null==($year))
			$year =  date("Y",time());	

		if(null==($month))
			$month = date("m",time());
			
		return date('t',strtotime($year.'-'.$month.'-01'));
	}

	public function add(){
		// Sanitize POST
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        
		if($post['submit']){
			if($post['title'] == '' || $post['content'] == ''){
				Messages::setMsg('Proszę wypełnić wszystkie pola', 'error');
				return;
			}
			
			$this->query('INSERT INTO events (title, content, date, user_id) VALUES(:title, :content, :date, :user_id)');
			$this->bind(':title', $post['title']);
			$this->bind(':content', $post['content']);
			$this->bind(':date', $post['date']);
			$this->bind(':user_id', $_SESSION['user_data']['id']);
			$this->execute();
			
			if($this->lastInsertId()){
				return true;
			}
		}

		return false;
	}
    
    public function showEvent($argument) {
        $this->query('SELECT * FROM events WHERE date = :date');
        $this->bind(':date', $argument);
		$row = $this->single();
		return $row;
    }
    
    public function editEvent($argument) {
        $row = $this->showEvent($argument);
        return $row;
    }
    
    public function changeEvent($argument) {
        		// Sanitize POST
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        
		if($post['submit']){
			if($post['title'] == '' || $post['content'] == ''){
				Messages::setMsg('Proszę wypełnić wszystkie pola', 'error');
				return;
			}
			
			$this->query('UPDATE events SET title = :title, content = :content WHERE date = :date');
			$this->bind(':title', $post['title']);
			$this->bind(':content', $post['content']);
			$this->bind(':date', $argument);
			$this->execute();
            
            return true;
		}

		return false;
    }
    
    public function deleteEvent($argument) {
        $this->query('DELETE FROM events WHERE date = :date');
        $this->bind(':date', $argument);
        $this->execute();
        return true;

    }
    
    private function translateMonth($currentDate) {
        
        $date = explode(' ', $currentDate);
        
        switch($date[1]) {
                case 'Jan':
                  return $date[0] . ' Styczeń';
                  break;

                case 'Feb':
                  return $date[0] . ' Luty';
                  break;

                case 'Mar':
                  return $date[0] . ' Marzec';
                  break;

                case 'Apr':
                  return $date[0] . ' Kwiecień';
                  break;  
                
                case 'May':
                  return $date[0] . ' Maj';
                  break;  
                
                case 'Jun':
                  return $date[0] . ' Czerwiec';
                  break;      
                
                case 'Jul':
                  return $date[0] . ' Lipiec';
                  break;    
                
                case 'Aug':
                  return $date[0] . ' Sierpień';
                  break;  
                
                case 'Sep':
                  return $date[0] . ' Wrzesień';
                  break;    
                
                case 'Oct':
                  return $date[0] . ' Październik';
                  break;    
                
                case 'Nov':
                  return $date[0] . ' Listopad';
                  break;
                
                case 'Dec':
                  return $date[0] . ' Grudzień';
                  break;

                default:
                  return 'Błąd';
                  break;
        }
    }
}

?>