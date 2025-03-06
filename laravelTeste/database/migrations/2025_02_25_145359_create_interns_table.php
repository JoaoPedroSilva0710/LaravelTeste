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
            DB::statement("CREATE FUNCTION update_column_ts_vector_search_name() RETURNS trigger
            LANGUAGE plgsql
            AS \$BODY$
            BEGIN
                update interns set ts_vector_search_name = to_tsvector(
                    'portuguese',
                    unnaccent(coalesce(NEW.name),'')

                );
                RETURN NEW 
            END;
            \$BODY$



    RETURN ;");

     });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interns');
    }
};
