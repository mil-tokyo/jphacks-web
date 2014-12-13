<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>Machine Learning</title>
        <?php echo \Asset::css(array(
            'joint.min.css',
            'joint.shapes.imgbox.css',
            'bootstrap.min.css',
            'style.css'
        )); ?>
    </head>
    <body>
        <div class="container">
            <div class="row" id="tool">
                <div id="pallet" class="col-md-3">
                    <button class="btn btn-primary" id="new-kmeans">K-means</button>
                    <button class="btn btn-primary" id="new-visualizer">Visualizer</button>
                </div>

                <div class="col-md-9">
                    <div id="canvasBox" class="col-md-9">
                        <div id="myholder">
                        </div>
                    </div>
                </div>

                <form id="executeForm" enctype="multipart/form-data">
                    <input type="button" id="execute" class="btn btn-primary" value="Execute">
                    <input type="file" name="file">
                </form>
            </div>
        </div>

        <?php echo \Asset::js(array(
            'joint.min.js',
            'joint.shapes.devs.min.js',
            'joint.shapes.erd.min.js',
            'joint.shapes.imgbox.js',
            'joint.shapes.devs.mlmodel.js',
            'main.js'
        )); ?>
    </body>
</html>