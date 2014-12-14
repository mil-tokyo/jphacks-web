
        <div id="loading">
            <div id="loading-img"><?php echo \Asset::img('loading.gif'); ?></div>
        </div>
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
