/*
 * Angular service for exception handling and reporting
 *
 * @params none
 *
 * @returns none
 */

ExceptionService.$inject = ['$log', '$http'];

function ExceptionService($log, $http) {

    var self = this;

    /****  Private Variables  ****/
    var env = 'production';
    var modes = {
        local: {
            verbose: true,
            consoleLog: true,
            remoteLog: false,
            alert: true,
            errorModal: true
        },
        staging: {
            verbose: false,
            consoleLog: true,
            remoteLog: true,
            alert: false,
            errorModal: true
        },
        production: {
            verbose: false,
            consoleLog: false,
            remoteLog: true,
            alert: false,
            errorModal: false
        }
    };

    /****  Public Variables  ****/


    /****  Initializations  ****/
    $http.get('/getEnv')
        .then(function (response) {
            env = response.data.env;
        }, function (error) {
            errorResponse(error);
        });


    /****  Public Functions  ****/
    self.logException = logException;
    self.errorResponse = errorResponse;

    /****  Private Functions  ****/

    /*
     * All errors/exceptions go through here
     *
     * @params location (string|required), description (string|required), data (array|optional), user (object|optional)
     *
     * @returns bool success
     */
    function logException (location, description, data, user) {

        if(data === undefined){
            data = [];
        }
        else if(!angular.isArray(data)){
            data = [data];
        }

        if(user === undefined){
            user = 'No user associated';
        }

        var ts = (new Date()).toISOString();

        if(modes[env].verbose){
            $log.error('New error created on ' + ts);
        }

        if(modes[env].consoleLog){
            $log.error(location, description, data, user);
        }

        if(modes[env].alert){
            toastr.error(description, location);
        }

        if(modes[env].remoteLog){
            $http.post('/logException', {
                location: location,
                description: description,
                data: data,
                user: user
            })
        }
    }

    /*
     * All http response errors go through this
     *
     * @params response (object|required)
     *
     * @returns bool success
     */
    function errorResponse (response) {
        $log.error('error response', response);
    }

}