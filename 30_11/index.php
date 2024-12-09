<?php
session_start();
require_once 'controllers/ProductController.php';

$action = $_GET['action'] ?? 'index';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'create':
        ProductController::create();
        break;
    case 'edit':
        ProductController::edit($id);
        break;
    case 'delete':
        ProductController::delete($id);
        break;
    default:
        ProductController::index();
        break;
}
?>
