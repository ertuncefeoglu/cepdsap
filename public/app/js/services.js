angular.module('myApp')

    // kullanıcı girişi için data provider
    .factory('AuthProvider', function($resource)
    {
        return $resource("/api/v1/authenticate/");
    })

    // ana menü ekranı için data provider
    .factory('MainMenu', function($resource)
    {
        return $resource("/api/v1/mainmenu");
    })

    // sevk menüsü için data provider
    .factory('SevkMenu', function($resource)
    {
        return $resource("/api/v1/sevkmenu");
    })

    // sevk düzenleme formu için data provider
    .factory('Sevk', function($resource)
    {
        return $resource("/api/v1/sevk/:mekan_kodu", {mekan_kodu:'@mekan_kodu'});
    })

    // uyarı mesajları için flash alert servisi
    .factory('Flash', function($rootScope)
    {
        return {
            show: function(message){
                $rootScope.flash = message
            },
            clear: function(){
                $rootScope.flash = ""
            }
        }
    })

    // http yanıtları için yakalayıcı servis
    // bütün http veri akışını izleyerek sunucudan dönen yanıtlara 
    // hook atmak için kullanılıyor
    .factory('myHttpInterceptor', function ($q)
    {
        return {
            response: function (response) {
                if(response.headers()['content-type'] === "application/json; charset=utf-8"){
                    // Validate response, if not ok reject
                    var data = examineJSONResponse(response); // assumes this function is available

                    if(!data)
                        return $q.reject(response);
                }
                return response;
            },
            responseError: function (response) {
                return $q.reject(response);
            }
        };
    });