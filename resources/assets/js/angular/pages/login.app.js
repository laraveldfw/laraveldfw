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