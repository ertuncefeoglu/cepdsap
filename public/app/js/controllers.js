angular.module('myApp')
    // login olma işlemlerinde kullanılan controller
    .controller('loginController',function($scope,$sanitize,$location,AuthProvider,Flash,myHttpInterceptor)
    {
        $scope.login = function(){
            AuthProvider.save({
                'username': $sanitize($scope.username),
                'password': $sanitize($scope.password)
            },function(response) {
                sessionStorage.token = response.token;
                $location.path('/home')
                Flash.clear()
                sessionStorage.authenticated = true;
            },function(response){
                Flash.show(response.data.flash)
            })
        }
    })
    // ana menüde kullanılan controller
    .controller('homeController',function($scope,$location,AuthProvider,MainMenu,Flash)
    {
        if (!sessionStorage.authenticated){
            $location.path('/')
            Flash.show("Bu alana erişebilmek için kullanıcı girişi yapmalısınız.")
        }
        MainMenu.get({},function(response){
            $scope.menus = response.menus
        })
        $scope.logout = function (){
            AuthProvider.get({},function(response){
                delete sessionStorage.authenticated
                Flash.show(response.flash)
                $location.path('/')
            })
        }
    })
    // sevk menüsünde kullanılan controller
    .controller('sevkMenuController',function($scope,$location,AuthProvider,SevkMenu,Flash)
    {
        if (!sessionStorage.authenticated){
            $location.path('/')
            Flash.show("Bu alana erişebilmek için kullanıcı girişi yapmalısınız.")
        }
        SevkMenu.get({},function(response){
            $scope.mekanlar = response.mekanlar
        })
        $scope.logout = function (){
            AuthProvider.get({},function(response){
                delete sessionStorage.authenticated
                Flash.show(response.flash)
                $location.path('/')
            })
        }
    })
    // sevk formunda kullanılan controller
    .controller('sevkFormController',function($scope,$window,$location,$routeParams,AuthProvider,Sevk,Flash)
    {
        var mekan_kodu = $routeParams.mekan_kodu;
        if (!sessionStorage.authenticated){
            $location.path('/')
            Flash.show("Bu alana erişebilmek için kullanıcı girişi yapmalısınız.")
        }
        Sevk.get({mekan_kodu:mekan_kodu},function(response){
            $scope.sevkler = response.sevkler
        })

        $scope.logout = function (){
            AuthProvider.get({},function(response){
                delete sessionStorage.authenticated
                Flash.show(response.flash)
                $location.path('/')
            })
        }

        $scope.submitForm = function(){
            $scope.editablesevkler = angular.copy($scope.sevkler);
            //console.table($scope.editablesevkler);
            Sevk.save({
                'sevkler': ($scope.editablesevkler)
            },function(response) {
                //console.table(response.sonuc);
                $scope.sevkler=angular.copy($scope.editablesevkler);
                $window.history.back();
            },function(response){
                Flash.show(response.data.flash);
            })
        }

        $scope.cancelForm = function () {
           $window.history.back();
        };
    })
