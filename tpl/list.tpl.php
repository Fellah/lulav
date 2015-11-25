<div class="wrap">
    <h1><?php echo $title?></h1>

    <?php foreach($marks as $id => $title): ?>
        <?php echo $id; ?> - <?php echo $title; ?><br />
    <?php endforeach; ?>
</div>
