<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration {
//     /**
//      * Run the migrations.
//      *
//      * @return void
//      */
//     public function up()
//     {
//         DB::statement("
//             CREATE VIEW total_amount_per_period
//             AS
//             SELECT periods.description, 
//             SUM(contributions.amount) AS totalAmount 
//             FROM contributions
//             JOIN periods ON contributions.period_id = periods.id
//             GROUP BY periods.description
//         ");
//     }

//     /**
//      * Reverse the migrations.
//      *
//      * @return void
//      */
//     public function down()
//     {
//         DB::statement("
//             DROP VIEW IF EXISTS total_amount_per_period
//         ");
//     }
// };