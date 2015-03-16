myVirtualStoryBookApp.service("PlayerService", ['BookService','GameService','$http',
    function(BookService,GameService, $http){
        
        var service = {};
        
        service.currentPlayer = {"username":"Okazari","password":"1"};
        
        service.getPlayerByName = function(name){
            return $http.get("http://myvirtualstorybook-okazari-4.c9.io/symfony/web/app_dev.php/players/"+name);
        }
 
        service.getConnectedPlayerBooks = function(){
            return BookService.getPlayerBooks(service.currentPlayer.username);
        }
 
        service.getConnectedPlayerGames = function(){
            return GameService.getPlayerGames(service.currentPlayer.username);
        }
 
        service.setCurrentPlayer = function(player){
            service.currentPlayer = player;
        }
 
        return service;
    }
]);