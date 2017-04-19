<?php

namespace go1\util\schema;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

class EnrolmentSchema
{
    public static function install(Schema $schema)
    {
        if (!$schema->hasTable('gc_enrolment')) {
            $enrolment = $schema->createTable('gc_enrolment');
            $enrolment->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
            $enrolment->addColumn('profile_id', 'integer', ['unsigned' => true]);
            $enrolment->addColumn('parent_lo_id', 'integer', ['unsigned' => true, 'notnull' => false, 'default' => 0, 'comment' => '@deprecated: Wrong design, we can not find parent enrolment from this value. This will be soon dropped.']);
            $enrolment->addColumn('parent_id', 'integer', ['unsigned' => true, 'notnull' => false, 'default' => 0, 'comment' => 'Parent enrolment ID.']);
            $enrolment->addColumn('lo_id', 'integer', ['unsigned' => true]);
            $enrolment->addColumn('instance_id', 'integer', ['unsigned' => true]);
            $enrolment->addColumn('taken_instance_id', 'integer', ['unsigned' => true]);
            $enrolment->addColumn('start_date', 'datetime');
            $enrolment->addColumn('end_date', 'datetime', ['notnull' => false]);
            $enrolment->addColumn('status', 'string');
            $enrolment->addColumn('result', 'float', ['notnull' => false]);
            $enrolment->addColumn('pass', 'smallint');
            $enrolment->addColumn('changed', 'datetime', ['unsigned' => true]);
            $enrolment->addColumn('timestamp', 'integer', ['unsigned' => true]);
            $enrolment->addColumn('data', 'blob', ['notnull' => false]);
            $enrolment->setPrimaryKey(['id']);
            $enrolment->addUniqueIndex(['profile_id', 'parent_lo_id', 'lo_id']);
            $enrolment->addIndex(['profile_id']);
            $enrolment->addIndex(['instance_id']);
            $enrolment->addIndex(['taken_instance_id']);
            $enrolment->addIndex(['status']);
            $enrolment->addIndex(['timestamp']);
            $enrolment->addIndex(['changed']);
            $enrolment->addIndex(['lo_id']);
        }

        if (!$schema->hasTable('gc_enrolment_revision')) {
            $revision = $schema->createTable('gc_enrolment_revision');
            $revision->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
            $revision->addColumn('enrolment_id', 'integer', ['unsigned' => true]);
            $revision->addColumn('profile_id', 'integer', ['unsigned' => true]);
            $revision->addColumn('parent_lo_id', 'integer', ['unsigned' => true, 'notnull' => false]);
            $revision->addColumn('parent_id', 'integer', ['unsigned' => true, 'notnull' => false, 'default' => 0, 'comment' => 'Parent enrolment ID.']);
            $revision->addColumn('lo_id', 'integer', ['unsigned' => true]);
            $revision->addColumn('instance_id', 'integer', ['unsigned' => true]);
            $revision->addColumn('taken_instance_id', 'integer', ['unsigned' => true]);
            $revision->addColumn('start_date', 'datetime');
            $revision->addColumn('end_date', 'datetime', ['notnull' => false]);
            $revision->addColumn('status', 'string');
            $revision->addColumn('result', 'float', ['notnull' => false]);
            $revision->addColumn('pass', 'smallint');
            $revision->addColumn('note', 'text');
            $revision->setPrimaryKey(['id']);
            $revision->addIndex(['profile_id']);
            $revision->addIndex(['instance_id']);
            $revision->addIndex(['taken_instance_id']);
            $revision->addIndex(['status']);
            $revision->addIndex(['lo_id']);
        }
    }

    public static function installManualRecord(Schema $schema)
    {
        if (!$schema->hasTable('enrolment_manual')) {
            $manual = $schema->createTable('enrolment_manual');
            $manual->addColumn('id', Type::INTEGER, ['unsigned' => true, 'autoincrement' => true]);
            $manual->addColumn('entity_type', Type::STRING);
            $manual->addColumn('entity_id', Type::INTEGER, ['unsigned' => true]);
            $manual->addColumn('user_id', Type::INTEGER, ['unsigned' => true]);
            $manual->addColumn('verified', Type::BOOLEAN);
            $manual->addColumn('data', Type::BLOB, ['notnull' => false]);
            $manual->addColumn('created', Type::INTEGER);
            $manual->addColumn('updated', Type::INTEGER);

            $manual->setPrimaryKey(['id']);
            $manual->addIndex(['user_id']);
            $manual->addIndex(['entity_type']);
            $manual->addIndex(['entity_id']);
            $manual->addUniqueIndex(['user_id', 'entity_type', 'entity_id']);
            $manual->addIndex(['verified']);
            $manual->addIndex(['created']);
            $manual->addIndex(['updated']);
        }
    }
}