<?php
class CalendarController extends Controller{	
    protected function Index(){
		$model = new Calendar();
		$this->returnView('index', $model->showCalendar($this->request));
	}
    
    protected function getName() {
		return 'calendar';
	}
    
    public function create() {
		if(!isset($_SESSION['is_logged_in'])){
			header('Location: '.ROOT_URL.'calendar');
		}

		$model = new Calendar();
		if ($model->add($this->request)) {
			Messages::setMsg('Wydarzenie dodane', 'success');
			$this->redirect('calendar');
		}
		else {			
			Messages::setMsg('Nie dodano wydarzenia', 'error');
			$this->redirect('calendar', 'add', $this->request);
		}
    
	}
    
    protected function add(){
		if(!isset($_SESSION['is_logged_in'])){
			header('Location: '.ROOT_URL.'calendar');
		}
        
        $model = new Calendar(); 
        if($model->showEvent($this->request)) {
            $this->redirect('calendar', 'showEvent', $this->request);
        } else {
		$this->returnView('add', $this->request);
        }
	}
    
    protected function showEvent() {
        $model = new Calendar();        
        $this->returnView('showEvent', $model->showEvent($this->request));
    }
    
    protected function editEvent() {
        if(!isset($_SESSION['is_logged_in'])){
			header('Location: '.ROOT_URL.'calendar');
		}
        
        $model = new Calendar();        
        $this->returnView('editEvent', $model->editEvent($this->request));
    }
    
    protected function changeEvent() {
        if(!isset($_SESSION['is_logged_in'])){
			header('Location: '.ROOT_URL.'calendar');
		}

		$model = new Calendar();
		if ($model->changeEvent($this->request)) {
			Messages::setMsg('Wydarzenie zostało zaktualizowane', 'success');
			$this->redirect('calendar');
		}
		else {			
			Messages::setMsg('Nie udało się zaktualizować wydarzenia', 'error');
			$this->redirect('calendar', 'showEvent', $this->request);
		}
    }
    
    protected function deleteEvent() {
        
        if(!isset($_SESSION['is_logged_in'])) {
			header('Location: '.ROOT_URL.'calendar');
		}

		$model = new Calendar();
		if ($model->deleteEvent($this->request)) {
			Messages::setMsg('Usunięto pomyślnie', 'success');
			$this->redirect('calendar');
		}
		else {
			Messages::setMsg('Nie udało się usunąć wydarzenia', 'error');
			$this->redirect('calendar', 'showEvent', $this->request);
		}
    }
}