<?php

session_start();

require_once __DIR__ . '/../inc/Database.php';
require_once __DIR__ . '/../model/Auth.php';

require_once __DIR__ . '/modelAdmin/modelAdmin.php';
require_once __DIR__ . '/modelAdmin/modelAdminAppointments.php';
require_once __DIR__ . '/modelAdmin/modelAdminCategory.php';
require_once __DIR__ . '/modelAdmin/modelAdminEmployees.php';
require_once __DIR__ . '/modelAdmin/modelAdminReviews.php';
require_once __DIR__ . '/modelAdmin/modelAdminServices.php';

require_once __DIR__ . '/controllerAdmin/controllerAdmin.php';
require_once __DIR__ . '/controllerAdmin/controllerAdminAppointments.php';
require_once __DIR__ . '/controllerAdmin/controllerAdminCategory.php';
require_once __DIR__ . '/controllerAdmin/controllerAdminEmployees.php';
require_once __DIR__ . '/controllerAdmin/controllerAdminRevies.php';
require_once __DIR__ . '/controllerAdmin/controllerAdminServices.php';

require_once __DIR__ . '/routeAdmin/routingAdmin.php';

echo $response;