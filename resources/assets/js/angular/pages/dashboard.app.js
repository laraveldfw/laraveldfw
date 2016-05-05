/*
* Tie together the dashboard app
*
* @params none
*
* @returns none
*/

var dashboardApp = angular.module('DashboardApp', ['ngMaterial', 'ngMessages', 'ngAutocomplete', 'ngMaterialDatePicker'])
    .service('AuthService', AuthService)
    .service('ExceptionService', ExceptionService)
    .service('MeetupService', MeetupService)
    .controller('DashboardController', DashboardController);