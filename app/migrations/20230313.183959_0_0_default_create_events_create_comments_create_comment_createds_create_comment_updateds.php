<?php

declare(strict_types=1);

namespace Migration;

use Cycle\Migrations\Migration;

class OrmDefault49c0b48cc31600adbc1a8a62f1ac7098 extends Migration
{
    protected const DATABASE = 'default';

    public function up(): void
    {
        $this->table('events')
        ->addColumn('id', 'primary', ['nullable' => false, 'default' => null])
        ->addColumn('action', 'string', ['nullable' => false, 'default' => null, 'size' => 255])
        ->addColumn('object_id', 'integer', ['nullable' => true, 'default' => null])
        ->addColumn('object_type', 'string', ['nullable' => true, 'default' => null, 'size' => 32])
        ->setPrimaryKeys(['id'])
        ->create();

        $this->table('comments')
        ->addColumn('id', 'primary', ['nullable' => false, 'default' => null])
        ->addColumn('body', 'string', ['nullable' => true, 'default' => null, 'size' => 255])
        ->setPrimaryKeys(['id'])
        ->create();
    }

    public function down(): void
    {
        $this->table('comments')->drop();
        $this->table('events')->drop();
    }
}
