register.config(function($stateProvider, $urlRouterProvider, $locationProvider, $httpProvider) {

    // $httpProvider.defaults.transformRequest = function(data) {
    //     if (data === undefined) {
    //         return data;
    //     }
    //     return $.param(data);
    // };

    // $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded; charset=UTF-8';

    $locationProvider.html5Mode(true);

    //
    // For any unmatched url, redirect to /
    $urlRouterProvider.otherwise("/");
    //
    // Now set up the states
    $stateProvider
        .state('home', {
            url: "/",
            controller: 'UsersController',
            templateUrl: "/app/templates/home/users.html"
        })
        .state('users', {
            url: "/users",
            controller: 'UsersController',
            templateUrl: "/app/templates/home/users.html"
        })
        .state('usreous', {
            url: "/usreous",
            controller: 'UsreousController',
            templateUrl: "/app/templates/home/usreous.html"
        })
        .state('activities', {
            url: "/activities",
            controller: 'ActivitiesController',
            templateUrl: "/app/templates/home/activities.html"
        });
});

register.run(function($rootScope, $state) {
    $rootScope.$state = $state;
});