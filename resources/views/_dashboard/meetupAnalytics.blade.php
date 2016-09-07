<section ng-show="activePane === 'analytics'">
    <div layout="row" layout-align="center center">
        <div class="md-display-1">Meetup Analytics</div>
    </div>
    <div layout="row" layout-wrap layout-margins>
        <div flex-xs=100" flex-gt-xs="100" flex-xl="45" layout="column" layout-align="center center" style="margin-right: 20px; margin-top: 20px;" class="md-whiteframe-3dp" ng-repeat="chart in charts">
            <div class="md-title" style="margin: 15px;">@{{ chart.title }}</div>
            <md-progress-circular ng-hide="chart.chart" style="margin-top: 20px;"></md-progress-circular>
            <div id="@{{ chart.id }}" style="height: 400px; width: 100%"></div>
        </div>
    </div>
</section>