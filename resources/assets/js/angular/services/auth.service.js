/*
 * Angular Service for authentication
 *
 * @params $http, $location, ExceptionService
 *
 * @returns none
 */

AuthService.$inject = ['$http', '$location', 'ExceptionService', '$mdToast'];

function AuthService($http, $location, ExceptionService, $mdToast) {

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
                        window.location.assign(redirect);
                    }
                    user = response.data.user;
                    return user;
                }
                else{
                    $mdToast.showSimple('Email/Password combo not found');
                    return false;
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
    
    self.getAllUsers = function () {
        return $http.get('/getAllUsers').then(function (response) {
            if(response.data.success){
                return response.data.users;
            }
        });
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