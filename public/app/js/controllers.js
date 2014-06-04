register.controller('UsersController',
    function($scope, $http, ACCESS_TOKEN, HOST) {
        $scope.users = [];

        $http.get(HOST + 'users?access_token=' + ACCESS_TOKEN).then(function(response) {
            $scope.users = response.data;
        });
    }
);

register.controller('HeaderController', ['$scope', '$http',
    function($scope, $http) {}
]);

register.controller('UsreousController',
    function($scope, $http, ACCESS_TOKEN, HOST) {

        $scope.usreous = [];

        $http.get(HOST + 'usreous?access_token=' + ACCESS_TOKEN).then(function(response) {
            $scope.usreous = response.data;
        });
    }
);

register.controller('ActivitiesController',
    function($scope, $http, ACCESS_TOKEN, HOST) {

        $scope.activites = [];

        $http.get(HOST + 'activites?access_token=' + ACCESS_TOKEN).then(function(response) {
            $scope.activites = response.data;
        });
    }
);