(function(){
	var app = angular.module('shalery', []);

	app.controller('TabController', function()
	{
		this.tab = 1;

		this.selectTab = function(setTab)
		{
			this.tab = setTab;
		};

		this.isSelected = function(checkTab)
		{
			return this.tab === checkTab;
		};
	});

	app.controller('RecentEventController', ['$http', '$sce', function($http, $sce){

		var store = this;
		store.events = [];

		$http.get('/api/event/recent').success(function(data, status){
			store.events = data;
		});

		// this.makeTrust = function(content_string){
		// 	return $sce.trustAsHtml(content_string);
		// };

	}]);

})();