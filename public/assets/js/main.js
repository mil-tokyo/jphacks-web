(function() {

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
        name: "source"
    }
});
graph.addCell(m1);

names = {};

$("#new-kmeans").click(function(){
    createKmeans(graph);
});
$("#new-visualizer").click(function(){
    createVisualizer(graph);
});
$("#execute").click(function(){
    var structure = integrateToArray(graph);
    console.log(data);
    $.ajax({
        url: "api/request.json",
        type: "post",
        data: {
            structure: JSON.stringify(structure)
        },
        success: function(res){
            console.log(res);
        }
    })
});

function createKmeans(graph){
    if (typeof self.count === 'undefined') {
        self.count = 0;
    }
    self.count++;

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
            name: "kmeans"+self.count,
            model_type: "KMeans",
            params: {
                n_clusters: "2"
            }
        }
    });
    graph.addCell(m1);

}

function createVisualizer(graph){
    if (typeof self.count === 'undefined') {
        self.count = 0;
    }
    self.count++;

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
            name: "visualizer"+self.count,
        }
    });
    graph.addCell(m1);
}

function integrateToArray(graph){
    data = {};

    _.each(graph.getElements(), function(element){
        _.each(graph.getConnectedLinks(element), function(link){
            var source_id = link.get('source').id;
            var target_id = link.get('target').id;
            var source = graph.getCell(source_id);
            var target = graph.getCell(target_id);
            var source_name = source.get('mlattrs')['name'];
            var target_name = target.get('mlattrs')['name'];

            data[source_name] = _.defaults(source.get('mlattrs'), data[source_name]);
            data[source_name].output = target_name;

            data[target_name] = _.defaults(target.get('mlattrs'), data[target_name]);
            data[target_name].input = source_name;
        });
    });

    dataArr = [];
    _.each(data, function(elem){
        dataArr.push(elem);
    })

    return dataArr;
}
}())