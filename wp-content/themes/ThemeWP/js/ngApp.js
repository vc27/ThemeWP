/**
 * File Name ngApp.js
 *
 **/
// ######################################################################


/**
 * ngApp
 **/
var ngApp = angular.module('ngApp', []);

ngApp.controller( 'ngAppCtrl', [
	'$scope'
	,'$sce'
	,'$timeout'
	,'$http'
	,function(
		$scope
		,$sce
		,$timeout
		,$http
	) {


	// $scope
	// ########################################
	$scope.text = 'yeah';
	$scope.l = siteObject; // l = local


	// General use
	// ########################################
	$scope.trustHtml = function(html) {
		return $sce.trustAsHtml(html);
	};


	// Initiate
	// ########################################
	$scope.init = function() {
		// $scope.setHash();
	};


	// Init -- Functions
	// ########################################
	jQuery(document).ready(function() {
		$scope.init();
	});


}]);
