var MlModel = joint.shapes.devs.Model.extend({
    defaults: joint.util.deepSupplement({
        mlattrs: {}
    }, joint.shapes.devs.Model.prototype.defaults)
});