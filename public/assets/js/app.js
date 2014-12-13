// http://victorblog.com/2012/12/20/make-angularjs-http-service-behave-like-jquery-ajax/
var app = angular.module('App', [], function($httpProvider) {
  // Use x-www-form-urlencoded Content-Type
  $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
 
  /**
   * The workhorse; converts an object to x-www-form-urlencoded serialization.
   * @param {Object} obj
   * @return {String}
   */ 
  var param = function(obj) {
    var query = '', name, value, fullSubName, subName, subValue, innerObj, i;
      
    for(name in obj) {
      value = obj[name];
        
      if(value instanceof Array) {
        for(i=0; i<value.length; ++i) {
          subValue = value[i];
          fullSubName = name + '[' + i + ']';
          innerObj = {};
          innerObj[fullSubName] = subValue;
          query += param(innerObj) + '&';
        }
      }
      else if(value instanceof Object) {
        for(subName in value) {
          subValue = value[subName];
          fullSubName = name + '[' + subName + ']';
          innerObj = {};
          innerObj[fullSubName] = subValue;
          query += param(innerObj) + '&';
        }
      }
      else if(value !== undefined && value !== null)
        query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
    }
      
    return query.length ? query.substr(0, query.length - 1) : query;
  };
 
  // Override $http service's default transformRequest
  $httpProvider.defaults.transformRequest = [function(data) {
    return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
  }];
});



app.controller('MainController', function($scope, $http, $interval, $filter){

	// mock
	var data_to_send = [
	{
		type: "data",
		name: "source1",
		input: "",
		output: "k-means",
    data : [[1,2],[1,3],[1,4],[10,1],[10.2],[10,3]]
	},
	{
		type: "model",
		name: "k-means1",
		input: "source1",
		output: "visualize1",
    model_type : "k-means",
    params : {"cluster_num" : 2}
	},
	{
		type: "visualize",
		name: "visualize1",
		input: "k-means1",
		output: ""
	}
	];

	// send data to server
	$http.post('api/request', {
		'structure': $filter('json')(data_to_send)
	}).success(function(data){
		// callback when returned
		console.log(data);
	});

	// request result to server repeatedly
	$interval(function(){
		$http.get('api/result.json').success(function(data){
			$scope.result = data;
			console.log(data);
		});
	}, 1000);


})