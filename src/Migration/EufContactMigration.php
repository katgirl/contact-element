<?php

declare(strict_types=1);

/*
 * Contact Element for Contao Open Source CMS.
 *
 * @copyright  Copyright (c) 2022, Erdmann & Freunde
 * @author     Erdmann & Freunde <https://erdmann-freunde.de>
 * @license    MIT
 * @link       http://github.com/nutshell-framework/contact-element
 */

namespace Nutshell\ContactElement\Migration;

use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Doctrine\DBAL\Connection;

class EufContactMigration extends AbstractMigration
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function shouldRun(): bool
    {
        $schemaManager = $this->connection->getSchemaManager();

        $columns = $schemaManager->listTableColumns('tl_content');

        return
        // column names needs to be written in lowercase!
         !isset($columns['contactname'], $columns['contactposition']);

        return
            $this->connection->fetchOne(
                "SELECT COUNT(*) FROM tl_content WHERE type = 'contact'"
            ) > 0;
    }

    public function run(): MigrationResult
    {

        $this->connection->executeQuery("
            ALTER TABLE
                tl_content

            ADD contactName varchar(255) NOT NULL default '',
            ADD contactPosition varchar(255) NOT NULL default '',
            ADD contactEmail varchar(255) NOT NULL default '',
            ADD contactPhone varchar(255) NOT NULL default '',
            ADD contactDescription mediumtext NULL
        ");

        $stmt = $this->connection->prepare('
            UPDATE
                tl_content
            SET
                contactName = contact_name,
                contactPosition = contact_position,
                contactEmail = contact_email,
                contactDescription = contact_description

            WHERE
                type = :type
        ');

        $stmt->bindValue('type', 'contact');
        $stmt->execute();

        return $this->createResult(true, 'Migrate euf_hero to hero-element');
    }
}
