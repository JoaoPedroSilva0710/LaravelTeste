<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Nette\Schema\Schema as SchemaSchema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('interns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->date('birth');
            $table->string('cpf')->unique();
            $table->rawColumn('ts_vector_search_name', 'tsvector')->nullable();
            $table->timestamps();
            $table->date('deleted_at')->nullable();

     });

    DB::statement("CREATE EXTENSION IF NOT EXISTS unaccent;");

    DB::statement("CREATE INDEX IF NOT EXISTS search_name_fulltext_idx ON interns USING gist(ts_vector_search_name)");


     DB::statement("CREATE OR REPLACE FUNCTION update_column_ts_vector_search_name() RETURNS trigger
     AS \$BODY$
     BEGIN
          NEW.ts_vector_search_name := to_tsvector(
             'portuguese',
             unaccent(coalesce(NEW.name, ''))
         );
         RETURN NEW;
     END;
     \$BODY$ 
     LANGUAGE plpgsql;");


     DB::statement("CREATE TRIGGER tgr_ts_vector_column_insert
     BEFORE INSERT
     OR UPDATE
     ON interns
     FOR EACH ROW
     EXECUTE FUNCTION update_column_ts_vector_search_name();");

    }

    /**
     * Reverse the migrations.
     */
public function down(): void
{
    // Drop the trigger first
    DB::statement("DROP TRIGGER IF EXISTS tgr_ts_vector_column_insert ON interns");

    // Drop the function without cascade
    DB::statement("DROP FUNCTION IF EXISTS update_column_ts_vector_search_name()");

    // Drop the interns table
    Schema::dropIfExists('interns');
}

};
