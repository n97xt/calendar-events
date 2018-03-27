<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Edytuj wydarzenie</h3>
  </div>
  <div class="panel-body">
    <form method="post" action="<?php echo ROOT_URL; ?>calendar/changeEvent?<?php echo($model['date']); ?>">
    	<div class="form-group">
    		<label>Tytuł</label>
    		<input type="text" name="title" class="form-control" value="<?php echo $model['title']; ?>" />
    	</div>
    	<div class="form-group">
    		<label>Treść</label>
    		<textarea name="content" class="form-control"><?php echo $model['content']; ?></textarea>
    	</div>
    <div class="form-group">
    		<label>Data</label>
    		<input type="date" name="date" class="form-control" value="<?php echo $model['date']; ?>" readonly="readonly"/>
    	</div>  		    		
    	<input class="btn btn-primary" name="submit" type="submit" value="Zapisz" />
        <a class="btn btn-danger" href="<?php echo ROOT_PATH; ?>calendar">Anuluj</a>
    </form>
  </div>
</div>