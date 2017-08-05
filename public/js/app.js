var app = angular.module('app', []);

app.controller('loginCtrl', function ($scope, $http) {

    $scope.login = function() {
        $http.post(
                "http://cepdsap.web/apilogin",
                {
                    username: $scope.username,
                    password: $scope.password
                }
            ).success(function(data){
                if(data == "success"){
                 $scope.responseMessage = "Successfully Logged In";
                }
                else {
                 $scope.responseMessage = "Username or Password is incorrect";
                }
            });
    }


});