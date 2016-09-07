/*
* Angular service for Meetup CRUD
*
* @params $http
*
* @returns none
*/
MeetupService.$inject = ['$http', 'ExceptionService', '$mdToast', '$mdDialog'];

function MeetupService ($http, ExceptionService, $mdToast, $mdDialog) {
    
    var self = this;
    
    /****  Private Variables  ****/
    var meetups = [];
    
    /****  Public Variables  ****/
    
    
    /****  Initializations  ****/
    
    
    /****  Public Functions  ****/
    self.getAllMeetups = getAllMeetups;
    self.saveNewMeetup = saveNewMeetup;
    
    /****  Private Functions  ****/
    
    /*
    * Gets all meetups past and present
    *
    * @params none
    *
    * @returns $http promise -> meetups array
    */
    function getAllMeetups () {
        return $http.get('getAllMeetups')
            .then(function (response) {
                if(response.data.success){
                    meetups = response.data.meetups;
                    return response.data.meetups;
                }
            })
    }    
    
    /*
    * Saves a new meetup
    *
    * @params meetup obj
    *
    * @returns $http promise
    */
    function saveNewMeetup (meetup) {
        if(moment){
            if(moment.isMoment(meetup.start_time)){
                meetup.start_time = meetup.start_time.format('YYYY-MM-DD HH:mm:ss');
            }
        }
        if(typeof meetup.start_time.getMonth === 'function'){
            var formattedDate = meetup.start_time.toISOString();
            formattedDate = formattedDate.slice(0, 19);
            formattedDate = formattedDate.replace('T', ' ');
            meetup.start_time = formattedDate;
        }

        return $http.post('/saveNewMeetup', meetup)
            .then(function (response) {
                if(response.data.success){
                    meetups.push(response.data.meetups);
                    $mdDialog.show(
                        $mdDialog.alert()
                            .parent(angular.element(document.body))
                            .clickOutsideToClose(true)
                            .title('Meetup Saved')
                            .textContent('The main page will show this meetup now.')
                            .ok('Got It!')
                    );
                    return response.data.meetup;
                }
            }, function (error) {
                ExceptionService.errorResponse(error);
                return error;
            })
    }

    /*
    * Gets all the members in laravel dfw meetup group
    *
    * @params none
    *
    * @returns Promise<array members>
    */
    self.getAllMembers = getAllMembers;
    function getAllMembers () {
        return $http.get('/getAllMembers')
            .then(function (response) {
                return response.data.members;
            }, function (error) {
                console.error(error);
            });
    }
}