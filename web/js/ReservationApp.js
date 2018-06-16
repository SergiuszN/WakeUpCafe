window.app = angular.module('ReservationApp', []).config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('[[').endSymbol(']]');
});

window.app.controller('ReservationController', ['$scope', function ($scope) {
    $scope.tables = [];
    $scope.date = new Date();
    $scope.loading = false;
    $scope.selectedTable = null;
    $scope.name = '';
    $scope.creating = false;

    $scope.reserve = function () {
        if (!$scope.canReserve()) {
            return;
        }

        $scope.creating = true;
        $.get(Routing.generate('app_reservation_api_create', {
            date: $scope.date.toJSON().slice(0,10),
            name: $scope.name,
            table: $scope.selectedTable
        }), function (data) {
            $scope.creating = false;
            $scope.$apply();
            window.location.href = Routing.generate('app_view_reservations');
        });
    };

    $scope.load = function () {
        $scope.loading = true;
        $.get(Routing.generate('app_reservation_api', {'date': $scope.date.toJSON().slice(0,10)}), function (data) {
            $scope.tables = data;
            $scope.loading = false;
            $scope.selectedTable = null;
            $scope.$apply();
            $(document).trigger('adaptive.resize');
        });
    };

    $scope.$watch('date', function () {  $scope.load(); });
    $scope.load();

    $scope.select = function (table) {
        $scope.tables.forEach(($v) => $v.selected = false);
        table.selected = (table.state === 'empty');
        $scope.selectedTable = (table.state === 'empty') ? table.id : null;
    };

    $scope.getClasses = function (table) {
        return {
            't2': table.number_of_person == 2,
            't4': table.number_of_person == 4,
            't6': table.number_of_person == 6,
            'empty': table.state == 'empty',
            'busy': table.state == 'busy',
            'selected': table.selected
        };
    };

    $scope.canReserve = function () {
        return ! ($scope.selectedTable === null || $scope.name === '');
    };
}]);

function adaptiveElement($container, $view, $viewWidth) {
    let $lastWidth = -1;

    function run(force) {
        let width = $container.width();

        if (!force) {
            if ($lastWidth === width) {
                return;
            }
        }

        let scale = width / $viewWidth;
        let marginLeft = -1 * ($viewWidth - width) / 2;
        let marginTop = (-1 * ($viewWidth - width) / 2) / ($viewWidth/$view.height());

        $view.css('transform', 'scale(' + scale + ')');
        $view.css('margin-left', marginLeft + 'px');
        $view.css('margin-top', marginTop + 'px');
        $view.css('margin-bottom', marginTop + 'px');

        $lastWidth = width;
    }

    $(window).resize(run);
    $(document).on('adaptive.resize', function () { run(true); });
    run();
}

adaptiveElement($('.container'), $('#ReservationController'), 1140);

