<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

// Incarca datele din fisierul .env
use Dotenv\Dotenv as DotenvInstance;

$dotenv = DotenvInstance::createImmutable(__DIR__);
$dotenv->load();

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

$connectionOptions = array(
    'driver'   => 'pdo_mysql',
    'host'     => $_ENV['DB_HOST'],
    'dbname'   => $_ENV['DB_NAME'],
    'user'     => $_ENV['DB_LOGIN'],
    'password' => $_ENV['DB_PASSWORD']
);

$entityManager = EntityManager::create($connectionOptions, $config);