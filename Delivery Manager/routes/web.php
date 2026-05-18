```php id="k9x2m4"
<?php

$routes = [

    '' => [
            'controller' => 'HomeController',
            'method' => 'index'
        ],

        'login' => [
            'controller' => 'AuthController',
            'method' => 'login'
        ],

        'dashboard' => [
            'controller' => 'DashboardController',
            'method' => 'index'
        ],

        'logout' => [
            'controller' => 'AuthController',
            'method' => 'logout'
        ],


        'manage-agents' => [
            'controller' => 'AgentController',
            'method' => 'index'
        ],

        'add-agent' => [
            'controller' => 'AgentController',
            'method' => 'create'
        ],

        'edit-agent' => [
            'controller' => 'AgentController',
            'method' => 'edit'
        ],

        'delete-agent' => [
            'controller' => 'AgentController',
            'method' => 'delete'
        ],

        'toggle-agent' => [
            'controller' => 'AgentController',
            'method' => 'toggle'
        ],

    

        'manage-zones' => [
            'controller' => 'ZoneController',
            'method' => 'index'
        ],

        'add-zone' => [
            'controller' => 'ZoneController',
            'method' => 'create'
        ],

        'edit-zone' => [
            'controller' => 'ZoneController',
            'method' => 'edit'
        ],

        'delete-zone' => [
            'controller' => 'ZoneController',
            'method' => 'delete'
        ],
    
        'ready-orders' => [
            'controller' => 'DeliveryController',
            'method' => 'readyOrders'
        ],

        'assign-order' => [
            'controller' => 'DeliveryController',
            'method' => 'assignOrder'
        ],

        'active-deliveries' => [
            'controller' => 'DeliveryController',
            'method' => 'activeDeliveries'
        ],

        'update-delivery-status' => [
            'controller' => 'DeliveryController',
            'method' => 'updateStatus'
        ],

        'failed-delivery' => [
            'controller' => 'DeliveryController',
            'method' => 'failedDelivery'
        ],

        'reassign-delivery' => [
            'controller' => 'DeliveryController',
            'method' => 'reassignDelivery'
        ],

        'delivery-history' => [
            'controller' => 'DeliveryController',
            'method' => 'history'
        ],

        'delivery-summary' => [
            'controller' => 'DeliveryController',
            'method' => 'summary'
        ],
       

        'agent-report' => [
            'controller' => 'ReportController',
            'method' => 'agentReport'
        ],

        'zone-report' => [
            'controller' => 'ReportController',
            'method' => 'zoneReport'
        ],

        'manage-profile' => [
            'controller' => 'ProfileController',
            'method' => 'manageProfile'
        ]
    ];

?>
```
