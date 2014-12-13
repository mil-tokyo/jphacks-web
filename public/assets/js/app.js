var app = angular.module('App', []);

app.controller('MainController', function($scope, $http, $interval, $filter){

	// mock
	var data_to_send = [
	{
		type: "data",
		name: "source1",
		input: "",
		output: "k-means"
	},
	{
		type: "classifier.k-means",
		name: "k-means1",
		input: "source1",
		output: "visualize1"
	},
	{
		type: "visualize",
		name: "visualize1",
		input: "k-means1",
		output: ""
	}
	];

	// send data to server
	$http.post('api/request.json', {
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