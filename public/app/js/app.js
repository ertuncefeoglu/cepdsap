angular.module("myApp",['ngRoute','ngResource','ngSanitize'])
    .config(['$routeProvider',function($routeProvider)
    {
        $routeProvider.when('/',
            { 
                templateUrl:'app/partials/login.html', 
                controller: 'loginController'
            }
        )
        $routeProvider.when('/home',
            {
                templateUrl:'app/partials/home.html',
                controller: 'homeController'
            }
        )
        $routeProvider.when('/sevk',
            {
                templateUrl:'app/partials/sevkmenu.html',
                controller: 'sevkMenuController'
            }
        )
        $routeProvider.when("/sevk/:mekan_kodu",
            {
                templateUrl: "app/partials/sevkform.html",
                controller: "sevkFormController"
            }
        )
        $routeProvider.otherwise(
            {
                redirectTo :'/'
            }
        )
    }])

    // csrf_token silinecek galiba
    .run(function($http,CSRF_TOKEN)
    {
        $http.defaults.headers.common['csrf_token'] = CSRF_TOKEN;
    })

    .config(function ($httpProvider)
    {
        $httpProvider.interceptors.push('myHttpInterceptor');
    });