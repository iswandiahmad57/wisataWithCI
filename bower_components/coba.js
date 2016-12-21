angular.module('app', ['datatables', 'ngResource'])
.controller('WithPromiseCtrl',['$scope','DTOptionsBuilder','DTColumnBuilder','$http','$q',function($scope,DTOptionsBuilder, DTColumnBuilder, $http, $q){
	    var vm = this;
    $scope.data="adfasdf";
    vm.dtOptions = DTOptionsBuilder.fromFnPromise(function() {
        var defer = $q.defer();
        $http.get('http://localhost/mrguides/api/produk/produks').then(function(result) {
            defer.resolve(result.data);
        });
        return defer.promise;
    }).withPaginationType('full_numbers');

    vm.dtColumns = [
        DTColumnBuilder.newColumn('productID').withTitle('ID'),
        DTColumnBuilder.newColumn('productName').withTitle('First name')
    ];
}])