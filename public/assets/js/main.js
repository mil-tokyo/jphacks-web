loadSample = {};

(function() {

var id_name_dir = {};
var graph = new joint.dia.Graph;
var paper = new joint.dia.Paper({
    el: $('#myholder'),
    width: 1000, height: 500, gridSize: 1,
    model: graph,
    defaultLink: new joint.dia.Link({
        attrs: { '.marker-target': { d: 'M 10 0 L 0 5 L 10 10 z' } }
    }),
    validateConnection: function(cellViewS, magnetS, cellViewT, magnetT, end, linkView) {
        // Prevent linking from input ports.
        if (magnetS && magnetS.getAttribute('type') === 'input') return false;
        // Prevent linking from output ports to input ports within one element.
        if (cellViewS === cellViewT) return false;
        // Prevent linking to input ports.
        return magnetT && magnetT.getAttribute('type') === 'input';
    },
    validateMagnet: function(cellView, magnet) {
        // Note that this is the default behaviour. Just showing it here for reference.
        // Disable linking interaction for magnets marked as passive (see below `.inPorts circle`).
        return magnet.getAttribute('magnet') !== 'passive';
    }
});

// icon size
var panel_width = 120, panel_height = 120;
var icon_width = 100, icon_height = 100;
var icon_left = (panel_width - icon_width)/2, icon_top = (panel_height - icon_height)/2;

// create input object
var m1 = new MlModel({
    position: { x: 50, y: 50 },
    size: { width: panel_width, height: panel_height },
    //inPorts: ['in'],
    outPorts: ['out'],
    attrs: {
        '.label': { text: '', 'ref-x': .4, 'ref-y': .2 },
        rect: { fill: '#2ECC71' },
        '.inPorts circle': { fill: '#16A085', magnet: 'passive', type: 'input' },
        '.outPorts circle': { fill: '#E74C3C', type: 'output' }
    },
    mlattrs: {
        type: "Data",
        name: "source"/*,
        data: {
            data: [[1,2],[2,3],[3,4], [10,11],[11,12],[12,13]],
            label: [0,0,0,1,1,1]
        }*/
    }
});
graph.addCell(m1);
registerIdNameList(m1);

appendImageToElement(m1, paper, 'assets/img/input.png');

$("#new-kmeans").click(function(){
    createKmeans(graph);
});
$("#new-svm").click(function(){
    createSVM(graph);
});
$("#new-linear-reg").click(function(){
    createLinearReg(graph);
});
$("#new-im-classifier").click(function(){
    createImageClassifier(graph);
});
$("#new-visualizer").click(function(){
    createVisualizer(graph);
});
$("#execute").click(function(){
    execute(graph);

    return false;
});
$("#executeForm").change(function(){
        var filelist = $('#executeForm input[type=file]').get()[0].files;
        var f = filelist[0];
        var reader = new FileReader();

        $("#list").empty();
        console.log(f);

        if (f.type.match('image.*')) {
            reader.onload = (function(theFile) {
                return function(e) {
                    var span = document.createElement('span');
                    span.innerHTML = ['<img class="thumb" src="', e.target.result,
                    '" title="', escape(theFile.name), '"/>'].join('');
                    document.getElementById('list').insertBefore(span, null);
                };
            })(f);
            reader.readAsDataURL(f);
        } else {
            $("#list").text(f.name);
        }

});

// load sample
loadSample.KMeans = function(){
    loadStructure([
    {
        "type": "Model",
        "tmpname": "kmeans1",
        "model_type": "KMeans",
        "params": {
            "n_clusters": 5
        },
        "input": "source",
        "output": "visualizer1"
    },
    {
        "type": "Visualizer",
        "tmpname": "visualizer1",
        "input": "kmeans1",
        "output": ""
    }
    ], graph);
}

loadSample.SVM = function(){
    loadStructure([
    {
        "type": "Model",
        "tmpname": "svc1",
        "model_type": "SVC",
        "params": {
            "kernel": "linear"
        },
        "input": "source",
        "output": "visualizer1"
    },
    {
        "type": "Visualizer",
        "tmpname": "visualizer1",
        "input": "kmeans1",
        "output": ""
    }
    ], graph);
}

loadSample.LinearReg = function(){
    loadStructure([
    {
        "type": "Model",
        "tmpname": "linear-reg1",
        "model_type": "LinearRegression",
        "params": {},
        "input": "source",
        "output": "visualizer1"
    },
    {
        "type": "Visualizer",
        "tmpname": "visualizer1",
        "input": "kmeans1",
        "output": ""
    }
    ], graph);
}

function loadStructure(structure, graph){
    // create elements
    var tmpname_name_dir = {};
    var res;
    _.each(structure, function(element){
        switch (element["type"]){
            case "Model":
            switch (element["model_type"]){
                case "KMeans":
                res = createKmeans(graph);
                break;
                case "SVC":
                res = createSVM(graph);
                break;
                case "LinearRegression":
                res = createLinearReg(graph);
                break;
            }
            break;

            case "Visualizer":
            res = createVisualizer(graph);
            break;
        }

        tmpname_name_dir[element['tmpname']] = res.get('mlattrs')['name'];
        console.log(element);
    });
    console.log(tmpname_name_dir);

    function tmpname_to_name(tmpname){
        if (tmpname === 'source'){
            return 'source';
        } else {
            return tmpname_name_dir[tmpname];
        }
    }

    // connect elements
    _.each(structure, function(element){
        var from = graph.getCell(getIdByName(tmpname_to_name(element['tmpname'])));
        var to = graph.getCell(getIdByName(tmpname_to_name(element['output'])));
        linkElements(from ,to, graph);
        var from = graph.getCell(getIdByName(tmpname_to_name(element['input'])));
        var to = graph.getCell(getIdByName(tmpname_to_name(element['tmpname'])));
        linkElements(from ,to, graph);
    });
}

function linkElements(from, to, graph){
    if (typeof from !== 'undefined' && typeof to !== 'undefined' && !isNeighbor(from, to, graph)){
        var l = new joint.shapes.devs.Link({
            source: {
                id: from.id,
                port: 'out'
            },
            target: {
                id: to.id,
                port: 'in'
            },
            attrs: { '.connection' : { 'stroke-width' :  2 }}
        });

        graph.addCells([from, to, l]);
    }
}

function isNeighbor(el1, el2, graph){
    var neighbors = graph.getNeighbors(el1);
    for (i in neighbors) {
        if (neighbors[i].id == el2.id) {
            return true;
        }
    }
    return false;
}

// handle drag event
function handleFileSelect(evt) {
    evt.stopPropagation();
    evt.preventDefault();

    var files = evt.dataTransfer.files; // FileList object.

    var formdata = new FormData();
    formdata.append('file', files[0]);
    execute(graph, formdata);
}

function handleDragOver(evt) {
    evt.stopPropagation();
    evt.preventDefault();
    evt.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
}

// Setup the dnd listeners.
var dropZone = document.getElementById('myholder');
dropZone.addEventListener('dragover', handleDragOver, false);
dropZone.addEventListener('drop', handleFileSelect, false);

function registerIdNameList(element){
    id_name_dir[element.get('mlattrs')['name']] = element.id;
}

function getIdByName(name){
    return id_name_dir[name];
}

function appendImageToElement(element, paper, img_path){
    var img = document.createElementNS('http://www.w3.org/2000/svg','image');
    img.setAttributeNS(null,'height', icon_height);
    img.setAttributeNS(null,'width', icon_width);
    img.setAttributeNS('http://www.w3.org/1999/xlink','href',img_path);
    img.setAttributeNS(null,'x', icon_left);
    img.setAttributeNS(null,'y', icon_top);
    img.setAttributeNS(null, 'visibility', 'visible');
    var view = element.findView(paper);
    var $svg = $(view.el).children('g');
    $svg.append(img);
    $svg = $svg.find('.body');
    $svg.attr('fill', '#efefef');
    $svg.attr('stroke', 'none');
}

function createKmeans(graph){
    if (typeof createKmeans.count === 'undefined') {
        createKmeans.count = 0;
    }
    createKmeans.count++;

    var m1 = new MlModel({
        position: { x: 50, y: 50 },
        size: { width: panel_width, height: panel_height },
        inPorts: ['in'],
        outPorts: ['out'],
        attrs: {
            '.label': { text: '', 'ref-x': .4, 'ref-y': .2 },
            rect: { fill: '#2ECC71' },
            '.inPorts circle': { fill: '#16A085', magnet: 'passive', type: 'input' },
            '.outPorts circle': { fill: '#E74C3C', type: 'output' }
        },
        mlattrs: {
            type: "Model",
            name: "kmeans"+createKmeans.count,
            model_type: "KMeans",
            params: {
                n_clusters: 5
            }
        }
    });
    graph.addCell(m1);
    appendImageToElement(m1, paper, 'assets/img/kmeans.png');
    registerIdNameList(m1);

    return m1;
}

function createSVM(graph){
    if (typeof createSVM.count === 'undefined') {
        createSVM.count = 0;
    }
    createSVM.count++;

    var m1 = new MlModel({
        position: { x: 50, y: 50 },
        size: { width: panel_width, height: panel_height },
        inPorts: ['in'],
        outPorts: ['out'],
        attrs: {
            '.label': { text: '', 'ref-x': .4, 'ref-y': .2 },
            rect: { fill: '#2ECC71' },
            '.inPorts circle': { fill: '#16A085', magnet: 'passive', type: 'input' },
            '.outPorts circle': { fill: '#E74C3C', type: 'output' }
        },
        mlattrs: {
            type: "Model",
            name: "svc"+createSVM.count,
            model_type: "SVC",
            params: {
                kernel: "linear"
            }
        }
    });
    graph.addCell(m1);
    appendImageToElement(m1, paper, 'assets/img/svm.png');
    registerIdNameList(m1);

    return m1;
}

function createLinearReg(graph){
    if (typeof createLinearReg.count === 'undefined') {
        createLinearReg.count = 0;
    }
    createLinearReg.count++;

    var m1 = new MlModel({
        position: { x: 50, y: 50 },
        size: { width: panel_width, height: panel_height },
        inPorts: ['in'],
        outPorts: ['out'],
        attrs: {
            '.label': { text: '', 'ref-x': .4, 'ref-y': .2 },
            rect: { fill: '#2ECC71' },
            '.inPorts circle': { fill: '#16A085', magnet: 'passive', type: 'input' },
            '.outPorts circle': { fill: '#E74C3C', type: 'output' }
        },
        mlattrs: {
            type: "Model",
            name: "linear-reg"+createLinearReg.count,
            model_type: "LinearRegression",
            params: {}
        }
    });
    graph.addCell(m1);
    appendImageToElement(m1, paper, 'assets/img/linreg.png');
    registerIdNameList(m1);

    return m1;
}

function createImageClassifier(graph){
    if (typeof createImageClassifier.count === 'undefined') {
        createImageClassifier.count = 0;
    }
    createImageClassifier.count++;

    var m1 = new MlModel({
        position: { x: 50, y: 50 },
        size: { width: panel_width, height: panel_height },
        inPorts: ['in'],
        outPorts: ['out'],
        attrs: {
            '.label': { text: '', 'ref-x': .4, 'ref-y': .2 },
            rect: { fill: '#2ECC71' },
            '.inPorts circle': { fill: '#16A085', magnet: 'passive', type: 'input' },
            '.outPorts circle': { fill: '#E74C3C', type: 'output' }
        },
        mlattrs: {
            type: "Model",
            name: "imclass"+createImageClassifier.count,
            model_type: "LinearSVC",
            params: {
                C: 1.0
            }
        }
    });
    graph.addCell(m1);
    appendImageToElement(m1, paper, 'assets/img/cls.png');
    registerIdNameList(m1);

    return m1;
}

function createVisualizer(graph){
    if (typeof createVisualizer.count === 'undefined') {
        createVisualizer.count = 0;
    }
    createVisualizer.count++;

    var m1 = new MlModel({
        position: { x: 50, y: 50 },
        size: { width: panel_width, height: panel_width },
        inPorts: ['in'],
        //outPorts: ['out'],
        attrs: {
            '.label': { text: '', 'ref-x': .4, 'ref-y': .2 },
            rect: { fill: '#2ECC71' },
            '.inPorts circle': { fill: '#16A085', magnet: 'passive', type: 'input' },
            '.outPorts circle': { fill: '#E74C3C', type: 'output' }
        },
        mlattrs: {
            type: "Visualizer",
            name: "visualizer"+createVisualizer.count,
        }
    });
    graph.addCell(m1);
    appendImageToElement(m1, paper, 'assets/img/vis.png');
    registerIdNameList(m1);

    return m1;
}

var timer_check_result;
function execute(_graph, formData){
    var structure = integrateToArray(_graph);
    console.log(data);

    //var form = $('#executeForm').get()[0];
    //var formData = new FormData(form);

    formData.append('structure', JSON.stringify(structure));

    $.ajax({
        url: "api/request.json",
        type: "post",
        dataType: "json",
        data: formData,
        /*
        data: {
            structure: JSON.stringify(structure)
        },
        */
        processData: false,
        contentType: false,
        success: function(res){
            console.log(res);
            if (res['stat'] != 1){
                alert('Fail: ' + res['msg']);
                return;
            }

            $("#loading").fadeIn();

            var queue_id = res['queue_id'];
            if (timer_check_result){
                clearInterval(timer_check_result);
            }
            timer_check_result = setInterval(function(){
                $.ajax({
                    url: "api/result.json",
                    type: "get",
                    async: false,
                    dataType: "json",
                    data: {
                        queue_id: queue_id
                    },
                    success: function(res){
                        console.log(res);
                        if (res['stat'] == 1){
                            clearInterval(timer_check_result);
                            applyResult(_graph, res['result']);
                            $("#loading").fadeOut();
                        } else if (res['stat'] == 0){
                            clearInterval(timer_check_result);
                            $("#loading").fadeOut();
                            alert('Error: ' + res['msg']);
                        }
                    }
                });
            }, 1000);
        }
    });
}

function applyResult(graph, result){
    _.each(result, function(row){
        var name = row['name'];
        var element = graph.getCell(id_name_dir[name]);
        if (element) {
            switch (element.get('mlattrs')['type']){
                case ('Visualizer'):
                applyResultVisualizer(graph, element, row);
                break;
            }
        }
    });
}

function applyResultVisualizer(graph, element, result){
    var x=100;
    var y=200;

    _.each(graph.getNeighbors(element), function(neighbor){
        if (neighbor instanceof joint.shapes.html.Element){
            neighbor.remove();
        }
    });
    _.each(graph.getNeighbors(element), function(neighbor){
        if (neighbor instanceof joint.shapes.erd.Entity){
            neighbor.remove();
        }
    });

    if ('img_src' in result){
        var el1 = new joint.shapes.html.Element({
            position: { x: x, y: y },
            size: { width: 170, height: 100 },
            img: result['img_src'] }
            );
        var l = new joint.dia.Link({
            source: { id: el1.id },
            target: { id: element.id },
            attrs: { '.connection': { 'stroke-width': 5, stroke: '#34495E' } }
        });

        graph.addCells([el1, element, l]);
    }
    if ('predict_class' in result) {
        var cell = new joint.shapes.erd.Entity({
            position: { x: 200, y: 200 },
            attrs: {
                text: { text: result['predict_class'], "font-size": "32px" },
            }
        });
        var l = new joint.dia.Link({
            source: { id: cell.id },
            target: { id: element.id },
            attrs: { '.connection': { 'stroke-width': 5, stroke: '#34495E' } }
        });

        graph.addCells([cell, element, l]);
    }
}

function integrateToArray(graph){
    data = {};

    _.each(graph.getElements(), function(element){
        _.each(graph.getConnectedLinks(element), function(link){
            var source_id = link.get('source').id;
            var target_id = link.get('target').id;
            var source = graph.getCell(source_id);
            var target = graph.getCell(target_id);

            if (source instanceof MlModel && target instanceof MlModel){
                var source_name = source.get('mlattrs')['name'];
                var target_name = target.get('mlattrs')['name'];
                var source_data = source.get('mlattrs');
                var target_data = target.get('mlattrs');

                data[source_name] = _.defaults(source.get('mlattrs'), data[source_name]);
                data[source_name].output = target_name;
                if (typeof data[source_name].input === "undefined"){
                    data[source_name].input = "";
                }

                data[target_name] = _.defaults(target.get('mlattrs'), data[target_name]);
                data[target_name].input = source_name;
                if (typeof data[target_name].output === "undefined"){
                    data[target_name].output = "";
                }
            }
        });
    });

    dataArr = [];
    _.each(data, function(elem){
        dataArr.push(elem);
    })

    return dataArr;
}
}());

function openImageModal(imgpath){
    console.log('open!');
    window.open(imgpath,'win','width=500,height=400,menubar=yes,status=yes,scrollbars=yes');
}
