/*
* Angular service for Meetup CRUD
*
* @params $http
*
* @returns none
*/
MeetupService.$inject = ['$http'];

function MeetupService ($http) {
    
    var self = this;
    
    /****  Private Variables  ****/
    var meetups = null;
    
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
            meetup.start_time = meetup.start_time.toISOString();
        }
        
        return $http.post('/saveNewMeetup', meetup);
    }    
}