/*
 * Angular Service for authentication
 *
 * @params $http, $location, ExceptionService
 *
 * @returns none
 */

AuthService.$inject = ['$http', '$location', 'ExceptionService'];

function AuthService($http, $location, ExceptionService) {

    var self = this;

    /****  Private Variables  ****/
    var user = null;

    /****  Initializations  ****/
    authCheck();

    /****  Public Functions  ****/

    /*
     * Logs in the user
     *
     * @params email (string|required), pwd (string|required), remember (bool|required), redirect (string|optional)
     *
     * @returns $http promise
     */
    self.login = function (email, pwd, remember, redirect) {
        return $http.post('/loginAttempt', {
                email: email,
                password: pwd,
                remember: remember
            })
            .then(function (response) {
                if(response.data.success){
                    if(redirect){
                        $location.url(redirect);
                    }
                    user = response.data.user;
                    return user;
                }
            }, function (error) {
                ExceptionService.errorResponse(error);
                return error;
            })
    };

    self.logout = function () {
        $location.url('/logout');
    };

    self.register = function () {
        //TODO fill out  
    };

    self.inviteNewUser = function () {
        //TODO fill out  
    };

    self.getUser = function () {
        return user;
    };

    self.isLoggedIn = function () {
        return user !== null;
    };
    
    self.sendResetEmail = function (email) {
        return $http.post('/sendResetEmail', {
            email: email
        });
    };
    
    self.getEmailRegex = function () {
        return /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    };

    /****  Private Functions  ****/

    function authCheck() {
        return $http.post('/authCheck')
            .then(function (response) {
                if(response.data.success){
                    user = response.data.user;
                }
                return response;
            }, function (error) {
                ExceptionService.errorResponse(error);
                return error;
            });
    }

}
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
/*
* Angular Controller for the login page
*
* @params $scope, AuthService
*
* @returns none
*/

LoginController.$inject = ['$scope', '$mdDialog', 'AuthService'];

function LoginController ($scope, $mdDialog, AuthService) {
    
    $scope.remember = false;
    $scope.forgotPwd = false;
    $scope.emailRegex = AuthService.getEmailRegex();
    
    $scope.login = function (loginForm) {
        if(loginForm.$valid){
            if($scope.forgotPwd){
                AuthService.sendResetEmail($scope.email).then(function (response) {
                    if(response.data.success){
                        var alert = $mdDialog.alert({
                            title: 'Check your inbox',
                            textContent: 'If ' + $scope.email + ' exists in our system then you will get a password reset email sent to you',
                            ok: 'Got It!'
                        });
                        $mdDialog.show(alert);
                    }
                }, function (error) {
                    console.log('response error', error);
                });
            }
            else {
                AuthService.login($scope.email, $scope.password, $scope.remember, '/dashboard');
            }
        }
    }
}
/*
* Bringing login page together
*
* @params LoginController
*
* @returns none
*/
var loginApp = angular.module('LoginApp', ['ngMaterial', 'ngMessages'])
    .service('AuthService', AuthService)
    .service('ExceptionService', ExceptionService)
    .controller('LoginController', LoginController);
//# sourceMappingURL=login.js.map
