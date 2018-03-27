<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">Wydarzenie - <?php echo $model['date']; ?></h1>
  </div>
  <div class="panel-body">
    <h2><?php echo $model['title']; ?></h2>
    <p><?php echo nl2br($model['content']); ?></p>
    
    <a class="btn btn-success" href="<?php echo ROOT_PATH; ?>calendar">Powrót</a>
    <?php if(isset($_SESSION['is_logged_in'])) : ?>
    <a class="btn btn-warning" href="<?php echo ROOT_PATH; ?>calendar/editEvent?<?php echo $model['date']; ?>">Edytuj</a>
    <a class="btn btn-danger" href="<?php echo ROOT_PATH; ?>calendar/deleteEvent?<?php echo $model['date']; ?>">Usuń</a>
    <?php endif; ?>
  </div>
</div>