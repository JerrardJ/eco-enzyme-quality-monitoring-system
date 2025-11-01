<?php if(count($errors) > 0): ?>
    <div class="msg error">
        <?php foreach ($errors as $error): ?>
            <li>
                <?php 
                echo $error;
                ?>
                <?php echo "<br>"."Please, try again!" ?>
            </li>
        <?php endforeach; ?>
    </div>
<?php endif; ?>