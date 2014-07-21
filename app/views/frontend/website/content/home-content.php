<div class="home-content" ng-controller="RecentEventController as recentCtrl">
	<img src="https://www.koshien.ac.jp/koshien-c/img/recruitment/bg_header.jpg" style="width:100%;height:100%">
	<div class="row">
		<div class="col-sm-9">
			<div class="events-list">
				<div ng-repeat="e in recentCtrl.events">
					<div class="row event-element">
						<div class="col-xs-2 col-md-1 date-md">
							<div class="date-wrapper">
								<span class="date-m">{{e.start_month}}月</span>
								<span class="date-d">{{e.start_date}}</span>
							</div>
						</div>
						<div class="col-xs-10 col-md-11">
							<div class="event-title">
								<a href="">{{e.title}}</a>
							</div>
							<div class="event-place">
								<i class="fa fa-location-arrow"></i><span class="padding-right">{{e.address || '未公開'}}</span>
							</div>
							<div class="event-description">
								{{e.description}}
							</div>
						</div>
					</div>
					<hr>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			
		</div>
	</div>
</div>