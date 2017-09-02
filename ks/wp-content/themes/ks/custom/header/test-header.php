<!DOCTYPE html>
<html>
<head lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no" />
    <meta charset="UTF-8">
    <title><?= TITLE .' | '.get_bloginfo('name');?></title>
    <?php
    wp_enqueue_script('jquery');
    wp_head();
    ?>
    <script>
        window.home_url = '<?=home_url();?>';
    </script>
</head>
<body>
