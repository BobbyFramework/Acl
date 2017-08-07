<?php

use BobbyFramework\Acl\Acl;
use BobbyFramework\Acl\Resource;
use BobbyFramework\Acl\Role;

define('APP_PATH', realpath('..'));

require APP_PATH . '/vendor/autoload.php';

$acl = new Acl();

// Add role acl
$rolesAdmins = new Role("admins", 'role admin');
$roleGuest = new Role('Guest');

$acl->addRole($rolesAdmins);
$acl->addRole($roleGuest);

// create resource
$customersResource = new Resource("Customers");

// Add right
$acl->addResource($customersResource, "search");
$acl->addResource($customersResource, [
        "create",
        "update",
    ]
);

$customersResource = new Resource("articles");
$acl->addResource($customersResource, "search");

// Assign access
$acl->allow("Guests", "Customers", "search");
$acl->allow("Guests", "Customers", "create");
$acl->allow("Guests", "articles", "create");
$acl->deny("Guests", "Customers", "update");
$acl->deny("admins", "articles", "create");

// TEST
// Returns 0
var_dump($acl->isAllowed("Guests", "Customers", "edit"));
// Returns 1
var_dump($acl->isAllowed("Guests", "Customers", "search"));
// Returns 1
var_dump($acl->isAllowed("Guests", "Customers", "create"));

// get all access
var_dump($acl->getAll());
