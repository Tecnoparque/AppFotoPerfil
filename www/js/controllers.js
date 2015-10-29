angular.module('appControllers', [])

.controller('HomeCtrl', ['$scope', '$rootScope', '$cordovaCamera', '$http', '$ionicPopup', '$routeParams', '$resource', function($scope, $rootScope, $cordovaCamera, $http, $ionicPopup, $routeParams, $resource) {

	$scope.ready = false;
	$scope.images = [];
    var base_url="http://127.0.0.1/AppFotoPerfil/www/";
$scope.id = $routeParams.CuentaId;
   // alert ($scope.id);
	
	$rootScope.$watch('appReady.status', function() {
		console.log('watch fired '+$rootScope.appReady.status);
		if($rootScope.appReady.status) $scope.ready = true;
	});


    	$scope.selImages = function() {
            
 
                $scope.obtenerFotoPerfil(2);
            
		window.imagePicker.getPictures(
			function(results) {
				for (var i = 0; i < results.length; i++) {
					console.log('Image URI: ' + results[i]);
					$scope.images.push(results[i]);
                    document.getElementById("imgProfile").src = results
                   // $scope.insertarFotoPerfil(results);
				}
				if(!$scope.$$phase) {
					$scope.$apply();
				}
			}, function (error) {
				console.log('Error: ' + error);
			},
             {
           maximumImagesCount: 1
          }
		);

	}
        
     $scope.obtenerFotosPerfil = function () {
            //update photo
      $http.get(base_url+'api/getPhotos').success(function(data){
         $scope.names = data;
        document.getElementById("imgProfile").src = data;
          //alert (data);
      }); 
    }
        
        
    $scope.obtenerFotoPerfil = function (id) {
            //update photo
//
//        var request_Id = $routeParams.requestId;
//        alert (request_Id);
//        var Request = $resource(base_url +'api/getPhoto', { id: 1 });

       // $scope.request = Request.get();
        
      $http.get(base_url+'api/getPhoto/'+1).success(function(data){
           $scope.names = data;
          //alert (JSON.stringify($scope.names[0].path_foto));
          document.getElementById("imgProfile").src = data[0].path_foto;
      }); 
    }
        
    $scope.insertarFotoPerfil = function () {
    $http.post(base_url+'api/addPhoto').success(function(){
        // add photo  
  var alertPopup = $ionicPopup.alert({
     title: 'Foto de perfil',
     template: 'Se ha subido correctamente la foto de perfil'
   });
     });

    }
    
    $scope.actualizarFotoPerfil = function (id)
    {
        //update photo
      $http.put(base_url+'api/updatePhoto'+1).success(function(){
           $scope.names = data;
      });
    }
    
    $scope.eliminarFotoPerfil = function (id){
    //delete photo
            if(confirm("¿Está seguro que quiere eliminar la foto de perfil?")){
    $http.delete(base_url+'api/deletePhoto/'+1).success(function(data){
        $scope.names = data;
      });
    }
    }
    
	
}])




