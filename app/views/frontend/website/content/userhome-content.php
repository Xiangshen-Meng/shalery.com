<div class="title-bar">
	モウ　ショウシン
	<hr>
</div>
<div class="row" ng-controller="TabController as tabCtrl">
	<div class="col-sm-3">
		<ul class="nav nav-pills nav-stacked">
			<li ng-class="{ active: tabCtrl.isSelected(1) }">
				<a href ng-click="tabCtrl.selectTab(1)">aaaa</a>
			</li>
			<li ng-class="{ active: tabCtrl.isSelected(2) }">
				<a href ng-click="tabCtrl.selectTab(2)">bbbb</a>
			</li>
			<li ng-class="{ active: tabCtrl.isSelected(3) }">
				<a href ng-click="tabCtrl.selectTab(3)">cccc</a>
			</li>
		</ul>
	</div>
	<div class="col-sm-9">
		<div ng-show="tabCtrl.isSelected(1)">
			Hello 1
		</div>
		<div ng-show="tabCtrl.isSelected(2)">
			Hello 2
		</div>
		<div ng-show="tabCtrl.isSelected(3)">	
			Hello 3
		</div>
	</div>
</div>