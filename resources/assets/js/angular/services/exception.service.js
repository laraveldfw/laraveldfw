/*
 * Angular service for exception handling and reporting
 *
 * @params $log, $http, $mdDialog, $mdToast
 *
 * @returns none
 */

ExceptionService.$inject = ['$log', '$http', '$mdDialog', '$mdToast'];

function ExceptionService($log, $http, $mdDialog, $mdToast) {

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
        if(modes[env].errorModal){
            if(angular.isString(response.data)){
                showDebugInfo(response.data);
            }
            else if(angular.isObject(response.data)){
                var toastString = 'Error: ';
                angular.forEach(response.data, function (value, key) {
                    if(angular.isArray(value)){
                        for (var i = 0; i < value.length; i++) {
                            toastString += value[i] + ' | ';
                        }
                    }
                });
                $mdToast.showSimple(toastString);
            }
        }
    }

    /*
    * Renders a dialog on the screen with debug details
    *
    * @params error html string
    *
    * @returns $mdDialog promise
    */
    function showDebugInfo (errorHtml) {
        return $mdDialog.show({
            parent: angular.element(document.body),
            template: errorHtml,
            clickOutsideToClose: true,
            fullscreen: true
        });
    }

}