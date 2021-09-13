<?php

namespace KitLoong\MigrationsGenerator\Generators\Modifier;

use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\Table;
use Illuminate\Support\Str;
use KitLoong\MigrationsGenerator\Generators\Blueprint\ColumnMethod;
use KitLoong\MigrationsGenerator\MigrationMethod\ColumnModifier;
use KitLoong\MigrationsGenerator\MigrationsGeneratorSetting;

class CharsetModifier
{
    public function chainCharset(Table $table, ColumnMethod $method, string $type, Column $column): ColumnMethod
    {
        if (!app(MigrationsGeneratorSetting::class)->isUseDBCollation()) {
            return $method;
        }

        // collation is not set in PgSQL
        $defaultCollation = $table->getOptions()['collation'] ?? '';
        $defaultCharset   = Str::before($defaultCollation, '_');

        $charset = $column->getPlatformOptions()['charset'] ?? null;
        if ($charset !== null && $charset !== $defaultCharset) {
            $method->chain(ColumnModifier::CHARSET, $charset);
        }

        return $method;
    }
}