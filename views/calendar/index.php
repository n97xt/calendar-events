
<div id="calendar">
    <div class="box">
    			<div class="header">
				<a class="prev" href="
				<?php echo ROOT_URL; ?>calendar?<?php echo $model['navi']['preYear']; ?>/<?php echo $model['navi']['preMonth'];?>
				">Poprzedni</a>
					<span class="title"><?php echo $model['navi']['currentDate']; ?></span>
				<a class="next" href="
				<?php echo ROOT_URL; ?>calendar?<?php echo $model['navi']['nextYear']; ?>/<?php echo $model['navi']['nextMonth'];?>
				">Następny</a>
			</div>
    </div>
    <div class="box-content">
        <ul class="label">
        
        <?php foreach($model['dayLabels'] as $label) : ?>
        
            <li class="col-md-2"><?php echo $label; ?></li>
        
        <?php endforeach;?></ul>	
        
        <div class="clear"></div>	
        <ul class="dates">	
        
        <?php foreach($model['content'] as $cellContent) : ?>
            <li class="col-md-2">    
	
	      <?php if(isset($_SESSION['is_logged_in'])) : ?>
            <a href="<?php echo ROOT_URL; ?>calendar/add?<?php echo $cellContent['date']; ?>">
            <?php echo $cellContent['content']; ?>
            </a>
          <?php else : ?>
            <p><?php echo $cellContent['content']; ?></p>

          <?php endif; ?>

          <?php foreach($model['events'] as $event) : ?>
            <?php if($event['date'] == $cellContent['date']) : ?>
                <a class="event-title" href="<?php echo ROOT_URL; ?>calendar/showEvent?<?php echo $cellContent['date']; ?>">
                <?php echo $event['title']; ?>
                </a>
            <?php endif; ?>
          <?php endforeach; ?>
            </li>
        <?php endforeach;?>
        
        </ul>
    <div class="clear"></div>	
    </div>	
</div>

