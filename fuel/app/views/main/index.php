<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>Machine Learning</title>
        <?php echo \Asset::css('joint.min.css'); ?>
    </head>
    <body>
        <div id="pallet">
            <button id="new-kmeans">K-means</button>
            <button id="new-visualizer">Visualizer</button>
        </div>
        <div id="myholder">
        </div>

        <button id="execute">Execute</button>

        <?php echo \Asset::js(array(
            'joint.min.js',
            'joint.shapes.devs.min.js',
            'joint.shapes.devs.mlmodel.js',
            'main.js'
        )); ?>
    </body>
</html>