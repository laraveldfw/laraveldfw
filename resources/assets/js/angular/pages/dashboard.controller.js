/*
* Angular Controller for the dashboard page
*
* @params $scope, AuthService
*
* @returns none
*/
DashboardController.$inject = ['$scope', 'AuthService', 'MeetupService'];

function DashboardController ($scope, AuthService, MeetupService) {
    
    
    $scope.$watch('placeDetails', function (details) {
        if(angular.isObject(details)){
            console.log(details);
            $scope.meetup.location_address = details.formatted_address;
            $scope.meetup.location_phone = details.formatted_phone_number;
            if(details.geometry){
                $scope.meetup.location_lat = details.geometry.location.lat();
                $scope.meetup.location_lng = details.geometry.location.lng();
            }
            $scope.meetup.location_url = details.website;
        }
    });
    
    $scope.createNewMeetup = function () {
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
        
        MeetupService.saveNewMeetup(meetup).then(function () {
            $scope.meetup = {};
            $scope.savingNewMeetup = false;
        });
    };
}