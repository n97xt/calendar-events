<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Dodaj nowe wydarzenie</h3>
  </div>
  <div class="panel-body">
    <form method="post" action="<?php echo ROOT_URL; ?>calendar/create?<?php echo($model); ?>">
    	<div class="form-group">
    		<label>Tytuł</label>
    		<input type="text" name="title" class="form-control" />
    	</div>
    	<div class="form-group">
    		<label>Treść</label>
    		<textarea name="content" class="form-control"></textarea>
    	</div>
    <div class="form-group">
    		<label>Data</label>
    		<input type="date" name="date" class="form-control" value="<?php echo($model); ?>" />
    	</div>  		    		
    	<input class="btn btn-primary" name="submit" type="submit" value="Dodaj" />
        <a class="btn btn-danger" href="<?php echo ROOT_PATH; ?>calendar">Anuluj</a>
    </form>
  </div>
</div>