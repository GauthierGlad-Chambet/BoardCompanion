<?php

namespace GauthierGladchambet\BoardCompanion\Tests;

use PDO;
use PHPUnit\Framework\TestCase;

abstract class IntegrationTestCase extends TestCase
{
    protected PDO $db;

    protected function setUp(): void
    {
        // Charger les variables d'environnement de test
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../', '.env.test');
        $dotenv->load();

        $this->db = new PDO(
            "mysql:host=" . $_ENV['DB_HOSTNAME'] . ";dbname=" . $_ENV['DB_DATABASE'] . ";charset=utf8",
            $_ENV['DB_USERNAME'],
            $_ENV['DB_PASSWORD'],
            [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
             PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        // Réinitialiser les tables avant chaque test
        $this->db->exec("SET FOREIGN_KEY_CHECKS = 0");
        $this->db->exec("TRUNCATE TABLE final_report");
        $this->db->exec("TRUNCATE TABLE sequence");
        $this->db->exec("TRUNCATE TABLE user_type_statistics");
        $this->db->exec("TRUNCATE TABLE project");
        $this->db->exec("TRUNCATE TABLE user");
        $this->db->exec("SET FOREIGN_KEY_CHECKS = 1");

        // Réinitialiser le singleton de connexion de MotherModel
        $reflection = new \ReflectionClass(\GauthierGladchambet\BoardCompanion\Models\MotherModel::class);
        $property = $reflection->getProperty('_dbInstance');
        $property->setAccessible(true);
        $property->setValue(null, null);
    }
}