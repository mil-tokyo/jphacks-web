
        <div id="loading">
            <div id="loading-img"><?php echo \Asset::img('loading.gif'); ?></div>
        </div>
        <div class="row" id="tool">
            <div id="pallet" class="col-md-3">
                <p class="btn-row" id="new-kmeans">
                    K-means
                    <?php echo \Asset::img('kmeans.png'); ?>
                </p>
                <p class="btn-row" id="new-svm">
                    SVM
                    <?php echo \Asset::img('knn.png', array('class' => 'pull-right')); ?>
                    <span class="clearfix"></span>
                </p>
                <p class="btn-row" id="new-linear-reg">
                    Linear Regression
                    <?php echo \Asset::img('knn.png', array('class' => 'pull-right')); ?>
                    <span class="clearfix"></span>
                </p>
                <p class="btn-row" id="new-im-classifier">
                    Image Classifier
                    <?php echo \Asset::img('knn.png', array('class' => 'pull-right')); ?>
                    <span class="clearfix"></span>
                </p>
                <p class="btn-row" id="new-visualizer">
                    Visualizer
                    <?php echo \Asset::img('knn.png', array('class' => 'pull-right')); ?>
                    <span class="clearfix"></span>
                </p>
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
