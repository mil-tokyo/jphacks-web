
        <div id="loading">
            <div id="loading-img"><?php echo \Asset::img('loading.gif'); ?></div>
        </div>
        <div class="row" id="tool">
            <div class="col-md-3">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#myModal">
                    Quick Start
                </button>
                <div id="pallet-wrapper" class="col-md-3">
                    <h4 class="text-center">Advanced</h4>
                    <hr>
                    <div class="panel-group" id="pallet" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#pallet" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Clustering
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <p class="btn-row" id="new-kmeans">
                                        K-means
                                        <?php echo \Asset::img('kmeans.png'); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#pallet" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Classification
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <p class="btn-row" id="new-svm">
                                        SVM<small>Support Vector Machines</small>
                                        <?php echo \Asset::img('svm.png', array('class' => 'pull-right')); ?>
                                        <span class="clearfix"></span>
                                    </p>
                                    <p class="btn-row">
                                        Logistic Regression
                                        <?php echo \Asset::img('logreg.png', array('class' => 'pull-right')); ?>
                                        <span class="clearfix"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#pallet" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Regression
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    <p class="btn-row" id="new-linear-reg">
                                        Linear Regression
                                        <?php echo \Asset::img('linreg.png', array('class' => 'pull-right')); ?>
                                        <span class="clearfix"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingFour">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#pallet" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        Image Classification
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                                <div class="panel-body">
                                    <p class="btn-row" id="new-im-classifier">
                                        HOG - SVM
                                        <?php echo \Asset::img('cls.png', array('class' => 'pull-right')); ?>
                                        <span class="clearfix"></span>
                                    </p>
                                    <p class="btn-row">
                                        CNN<small>Convolutional Neural Network</small>
                                        <?php echo \Asset::img('cnn.png', array('class' => 'pull-right')); ?>
                                        <span class="clearfix"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingFive">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#pallet" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        Data Processing
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                                <div class="panel-body">
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
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingSix">
                                <h4 class="panel-title">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#pallet" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                        Utility
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                                <div class="panel-body">
                                    <p class="btn-row" id="new-visualizer">
                                        Visualizer
                                        <?php echo \Asset::img('vis.png', array('class' => 'pull-right')); ?>
                                        <span class="clearfix"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <button class="btn btn-danger btn-block" href="#" onclick="util.clearGraph(); return false;">Clear</button>
            </div>

            <div class="col-md-9">
                <div id="canvasBox">
                    <div id="myholder">
                    </div>
                </div>
                <!--
                <form id="executeForm" enctype="multipart/form-data">
                    <div class="file">
                        Select File
                        <input type="file" name="file" value="Select file">
                    </div>
                    <output id="list"></output>
                    <input type="button" id="execute" class="btn btn-primary btn-block btn-bg" value="Execute">
                </form>
            -->
            </div>


        </div>

<!-- Modal -->
<div class="modal fade  bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-load-sample">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Quick Start</h4>
            </div>
            <div class="modal-body">
                <div class="btn btn-default btn-load-sample" onclick="loadSample.KMeans();" data-dismiss="modal">
                    <h4>k-means</h4>
                    <p>
                        データ点をk個のクラスター（近い点同士の集まり）に分割します．
                    </p>
                </div>
                <div class="btn btn-default btn-load-sample" onclick="loadSample.SVM();" data-dismiss="modal">
                    <h4>SVM</h4>
                    <p>
                        データ点を2つのクラスに分類します．<br>
                        初めにクラスラベル付きデータを入力してモデルを学習し，<br>
                        学習したモデルに対して識別したいクラスラベル未知のデータを入力します．
                    </p>
                </div>
                <div class="btn btn-default btn-load-sample" onclick="loadSample.LinearReg();" data-dismiss="modal">
                    <h4>Linear Regression</h4>
                    <p>
                        データ点を最もよく近似する直線を求めます．
                    </p>
                </div>
                <div class="btn btn-default btn-load-sample" onclick="loadSample.ImageClassifier();" data-dismiss="modal">
                    <h4>Image Classification</h4>
                    <p>
                        入力画像に写っている物体の名称を得ます．
                    </p>
                </div>
                <p class="clearfix"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

