/*
* Angular Controller for the dashboard page
*
* @params $scope, AuthService
*
* @returns none
*/
DashboardController.$inject = ['$scope', '$timeout', 'AuthService', 'MeetupService'];

function DashboardController ($scope, $timeout, AuthService, MeetupService) {

    $scope.meetup = {
        online: false
    };
    
    $scope.$watch('placeDetails', function (details) {
        if(angular.isObject(details)){
            console.log(details);
            $scope.meetup.location_address = details.formatted_address;
            $scope.meetup.location_phone = details.formatted_phone_number;
            if(details.geometry){
                $scope.meetup.location_lat = parseFloat(details.geometry.location.lat());
                $scope.meetup.location_lng = parseFloat(details.geometry.location.lng());
            }
            $scope.meetup.location_url = details.website;
        }
    });
    
    $scope.createNewMeetup = function (newMeetupForm) {
        $scope.savingNewMeetup = true;
        var meetup;
        if($scope.meetup.online){
            meetup = {
                online: $scope.meetup.online,
                talk: $scope.meetup.talk
            };
            if($scope.meetup.speaker){
                meetup.speaker = $scope.meetup.speaker;
            }
            if($scope.meetup.speaker_img){
                meetup.speaker = $scope.meetup.speaker_img;
            }
            if($scope.meetup.speaker_url){
                meetup.speaker = $scope.meetup.speaker_url;
            }
        }
        else{
            meetup = angular.copy($scope.meetup);
        }
        
        MeetupService.saveNewMeetup(meetup).then(function (savedMeetup) {
            $scope.meetup = {
                online: false
            };
            $scope.savingNewMeetup = false;
            newMeetupForm.$setUntouched();
            newMeetupForm.$setPristine();
        });
    };

    var latLngs = [];
    $scope.$watch('activePane', function (pane) {
        if (pane === 'analytics' && !$scope.members) {
            MeetupService.getAllMembers().then(function (members) {
                $scope.members = members;
                console.log(members);
                /* Members are so spread out I don't need it yet
                // generate array formatted to work with geolib library
                for (var j = 0; j < members.length; j++) {
                    if (members[j].lat) {
                        latLngs.push({
                            latitude: members[j].lat,
                            longitude: members[j].lon
                        });
                    }
                }
                */
                for (var i = 0; i < $scope.charts.length; i++) {
                    drawChart($scope.charts[i]);
                }
            })
        }
    });

    var numTopics = 50;
    $scope.charts = [
        {
            id: 'memberLocations',
            title: 'Member Locations'
        },
        {
            id: 'favoriteTopics',
            title: 'Top ' + numTopics + ' Favorite Topics'
        },
        {
            id: 'growthChart',
            title: 'Membership Growth'
        }
    ];

    function drawChart (chart) {
        switch (chart.id) {
            case 'memberLocations':
                chart.chart = new google.maps.Map(document.getElementById(chart.id), {
                    center: {lat: 32.7767, lng: -96.7670},
                    zoom: 9
                });
                chart.markers = [];
                for (var i = 0; i < $scope.members.length; i++) {
                    chart.markers[i] = new google.maps.Marker({
                        map: chart.chart,
                        animation: google.maps.Animation.DROP,
                        title: $scope.members[i].name,
                        position: {lat: $scope.members[i].lat, lng: $scope.members[i].lon}
                    });
                }
                break;
            case 'favoriteTopics':
                var topics = {};
                for (var j = 0; j < $scope.members.length; j++) {
                    if ($scope.members[j].topics && $scope.members[j].topics.length > 0) {
                        var mtopics = $scope.members[j].topics;
                        for (var k = 0; k < mtopics.length; k++) {
                            if (topics[mtopics[k].urlkey]) {
                                topics[mtopics[k].urlkey].count++;
                            }
                            else {
                                topics[mtopics[k].urlkey] = {
                                    id: mtopics[k].id,
                                    name: mtopics[k].name,
                                    count: 1
                                }
                            }
                        }
                    }
                }
                var topicData = [];
                angular.forEach(topics, function (tpc, urlkey) {
                    topicData.push([tpc.name, tpc.count]);
                });
                topicData.sort(function (a, b) {
                   return b[1] - a[1];
                });
                topicData = topicData.slice(0, numTopics - 1);
                topicData.unshift(['Topics', 'Members']);
                var data = google.visualization.arrayToDataTable(topicData);
                chart.chart = new google.visualization.ColumnChart(document.getElementById(chart.id));
                chart.chart.draw(data, {
                    legend: {position: 'none'},
                    hAxis: {
                        slantedText: true,
                        slantedTextAngle: 45
                    },
                    vAxis: {
                        title: '# of Members'
                    },
                    animation: {
                        duration: 500,
                        easing: 'out',
                        startup: true
                    },
                    chartArea: {
                        top: 10
                    }
                });
                break;
            case 'growthChart':
                var mems = angular.copy($scope.members);
                mems.sort(function (a, b) {
                    return a.joined - b.joined;
                });
                var growthData = [];
                for (var i = 0; i < mems.length; i++) {
                    var joined = moment(mems[i].joined);
                    if (i === 0 || joined.format('MMM YY') !== growthData[growthData.length - 1][0]) {
                        var newMonth = [
                            joined.format('MMM YY'),
                            (growthData.length === 0 ? 1 : growthData[growthData.length - 1][1] + 1)
                        ];
                        growthData.push(newMonth);
                    }
                    else {
                        growthData[growthData.length - 1][1]++;
                    }
                }
                growthData.unshift(['Date', 'Membership Count']);
                var data = google.visualization.arrayToDataTable(growthData);
                chart.chart = new google.visualization.AreaChart(document.getElementById(chart.id));
                chart.chart.draw(data, {
                    legend: {position: 'none'},
                    animation: {
                        duration: 500,
                        easing: 'out',
                        startup: true
                    },
                    hAxis: {
                        slantedText: true,
                        slantedTextAngle: 45
                    }
                });
                break;
            default:
                console.error('chart not defined', chart);
                break;
        }
    }
}