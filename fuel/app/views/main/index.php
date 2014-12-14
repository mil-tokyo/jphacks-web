
        <div id="loading">
            <div id="loading-img"><?php echo \Asset::img('loading.gif'); ?></div>
        </div>
        <div class="row" id="tool">
            <div class="col-md-3">
                <div id="pallet-wrapper" class="col-md-3">
                    <div id="pallet">
                        <p class="btn-row" id="new-kmeans">
                            K-means
                            <?php echo \Asset::img('kmeans.png'); ?>
                        </p>
                        <p class="btn-row" id="new-svm">
                            SVM<small>Support Vector Machines</small>
                            <?php echo \Asset::img('svm.png', array('class' => 'pull-right')); ?>
                            <span class="clearfix"></span>
                        </p>
                        <p class="btn-row" id="new-linear-reg">
                            Linear Regression
                            <?php echo \Asset::img('linreg.png', array('class' => 'pull-right')); ?>
                            <span class="clearfix"></span>
                        </p>
                        <p class="btn-row" id="new-im-classifier">
                            Image Classifier
                            <?php echo \Asset::img('cls.png', array('class' => 'pull-right')); ?>
                            <span class="clearfix"></span>
                        </p>
                        <p class="btn-row" id="new-visualizer">
                            Visualizer
                            <?php echo \Asset::img('vis.png', array('class' => 'pull-right')); ?>
                            <span class="clearfix"></span>
                        </p>

                        <p class="btn-row">
                            CNN<small>Convolutional Neural Network</small>
                            <?php echo \Asset::img('cnn.png', array('class' => 'pull-right')); ?>
                            <span class="clearfix"></span>
                        </p>
                        <p class="btn-row">
                            Logistic Regression
                            <?php echo \Asset::img('logreg.png', array('class' => 'pull-right')); ?>
                            <span class="clearfix"></span>
                        </p>
                        <p class="btn-row">
                            PCA<small>Principal Component Analysys</small>
                            <?php echo \Asset::img('pca.png', array('class' => 'pull-right')); ?>
                            <span class="clearfix"></span>
                        </p>
                        <p class="btn-row">
                            Standardization
                            <?php echo \Asset::img('std.png', array('class' => 'pull-right')); ?>
                            <span class="clearfix"></span>
                        </p>
                        <p class="btn-row">
                            Whitening
                            <?php echo \Asset::img('whiten.png', array('class' => 'pull-right')); ?>
                            <span class="clearfix"></span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div id="canvasBox">
                    <div id="myholder">
                    </div>
                </div>
            </div>

            <form id="executeForm" enctype="multipart/form-data">
                <input type="button" id="execute" class="btn btn-primary" value="Execute">
                <input type="file" name="file">
            </form>
        </div>
