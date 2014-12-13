(function() {

var id_name_dir = {};
var graph = new joint.dia.Graph;
var paper = new joint.dia.Paper({
    el: $('#myholder'),
    width: 1000, height: 400, gridSize: 1,
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

// create input object
var m1 = new MlModel({
    position: { x: 50, y: 50 },
    size: { width: 90, height: 90 },
    //inPorts: ['in'],
    outPorts: ['out'],
    attrs: {
        '.label': { text: 'Input', 'ref-x': .4, 'ref-y': .2 },
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



$("#new-kmeans").click(function(){
    createKmeans(graph);
});
$("#new-visualizer").click(function(){
    createVisualizer(graph);
});
$("#execute").click(function(){
    execute(graph);

    return false;
});

function registerIdNameList(element){
    id_name_dir[element.get('mlattrs')['name']] = element.id;
}

function createKmeans(graph){
    if (typeof createKmeans.count === 'undefined') {
        createKmeans.count = 0;
    }
    createKmeans.count++;

    var m1 = new MlModel({
        position: { x: 50, y: 50 },
        size: { width: 90, height: 90 },
        inPorts: ['in'],
        outPorts: ['out'],
        attrs: {
            '.label': { text: 'k-Means', 'ref-x': .4, 'ref-y': .2 },
            rect: { fill: '#2ECC71' },
            '.inPorts circle': { fill: '#16A085', magnet: 'passive', type: 'input' },
            '.outPorts circle': { fill: '#E74C3C', type: 'output' }
        },
        mlattrs: {
            type: "Model",
            name: "kmeans"+createKmeans.count,
            model_type: "KMeans",
            params: {
                n_clusters: "2"
            }
        }
    });
    graph.addCell(m1);
    registerIdNameList(m1);
}

function createVisualizer(graph){
    if (typeof createVisualizer.count === 'undefined') {
        createVisualizer.count = 0;
    }
    createVisualizer.count++;

    var m1 = new MlModel({
        position: { x: 50, y: 50 },
        size: { width: 90, height: 90 },
        inPorts: ['in'],
        //outPorts: ['out'],
        attrs: {
            '.label': { text: 'Visualizer', 'ref-x': .4, 'ref-y': .2 },
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
    registerIdNameList(m1);
}

var timer_check_result;
function execute(_graph){
    var structure = integrateToArray(_graph);
    console.log(data);

    var form = $('#executeForm').get()[0];
    var formData = new FormData(form);

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
                        if (res['stat'] == 1){
                            clearInterval(timer_check_result);
                            applyResult(_graph, res['result']);
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

    var n_imgbox = 0;
    _.each(graph.getNeighbors(element), function(neighbor){
        if (neighbor instanceof joint.shapes.html.Element){
            neighbor.remove();
        }
    });

    var el1 = new joint.shapes.html.Element({
        position: { x: x, y: y },
        size: { width: 170, height: 100 },
        img: result['img'] }
        );
    var l = new joint.dia.Link({
        source: { id: el1.id },
        target: { id: element.id },
        attrs: { '.connection': { 'stroke-width': 5, stroke: '#34495E' } }
    });

    graph.addCells([el1, element, l]);
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

                data[source_name] = _.defaults(source.get('mlattrs'), data[source_name]);
                data[source_name].output = target_name;

                data[target_name] = _.defaults(target.get('mlattrs'), data[target_name]);
                data[target_name].input = source_name;
            }
        });
    });

    dataArr = [];
    _.each(data, function(elem){
        dataArr.push(elem);
    })

    return dataArr;
}
}())