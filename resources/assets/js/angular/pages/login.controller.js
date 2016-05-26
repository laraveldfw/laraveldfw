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