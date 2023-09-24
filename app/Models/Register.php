<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\WerehouseStatus;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class Register extends Model
{
    use HasFactory;

    protected $fillable = ['deposit', 'liquor_shop', 'ordered'];

    public function werehouseStatus(){
        return $this->belongsTo(WerehouseStatus::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public static function createTemporaryTables($actualStatus, $previousStatus = null){
        /* --- 
            Si hay un Estado de Bodega previo, entonces crea una tabla temporal
            con sus registros para obtener la columna `total_count` correspondiente
            a la cuenta total de unidades
         ---*/
        if($previousStatus){
            // Obtiene los identificadores (id) de los registros del Estado de Bodega previo
            $identifiers = [];
            foreach($previousStatus->registers as $register){
                $identifiers[] = $register->id;
            }
            $identifiers = implode(',', $identifiers);
            // $identifiers = implode([0, 1, 2, 3]) = '0,1,2,3';

            DB::unprepared("
                -- Crea una tabla temporal con los registros del Estado de Bodega previo

                CREATE TEMPORARY TABLE IF NOT EXISTS previous_registers AS (
                    SELECT
                        `registers`.`id`,
                        `products`.`id` AS `product_id`,
                        `registers`.`deposit`,
                        `registers`.`liquor_shop`
                    FROM
                        `registers`
                        INNER JOIN `products` ON `products`.`id` = `registers`.`product_id`
                        INNER JOIN `types` ON `types`.`id` = `products`.`type_id`
                        INNER JOIN `presentations` ON `presentations`.`id` = `products`.`presentation_id`
                    WHERE
                        `registers`.`id` IN ($identifiers)
                );

                -- Agrega la columna `total_count` correspondiente a la cuenta total de unidades

                ALTER TABLE previous_registers ADD COLUMN total_count INT DEFAULT 0;
                UPDATE previous_registers SET
                    `total_count` = `deposit` + `liquor_shop`
                WHERE `id` > 0;
            ");            
        }
        
        /* --- 
            Crea una segunda tabla temporal la cual contiene la informacion que le
            mostraremos al usuario. Esta informacion es obtenida haciendo calculos 
            con los registros del Estado de Bodega actual y, si es nesesario, tambien
            los del registros del Estado de Bodega previo
         --- */
        if($previousStatus){
            /*
                Agrega el codigo SQL nesesario para obtener la cuenta total de unidades (correspondiente a la
                columna `total_count`) del Estado de Bodega previo, cuyos registros guardamos antes en la
                tabla temporal `previous_registers`
            */
            $previousRegistersSQL = [
                "previousCount" => ", `previous_registers`.`total_count` AS `previous_count`",
                "leftJoin" => "LEFT JOIN `previous_registers` ON `registers`.`product_id` = `previous_registers`.`product_id`",
                "sales" => "(`previous_count` + `ordered`) - total_count"
            ];
        } else {
            // Si no tenemos Estado de Bodega previo anula la consulta
            $previousRegistersSQL = [
                "previousCount" => '',
                "leftJoin" => '',
                "sales" => '0'
            ];
        }

        // Obtiene los identificadores (id) de los registros del Estado de Bodega actual
        $identifiers = [];
        foreach($actualStatus->registers as $register){
            $identifiers[] = $register->id;
        }
        $identifiers = implode(',', $identifiers);
        // [0, 1, 2, 3] = '0,1,2,3'

        DB::unprepared(" 
            -- Crea una tabla temporal con los registros del Estado de Bodega Actual
            CREATE TEMPORARY TABLE IF NOT EXISTS raw_registers AS (
                SELECT
                    `registers`.`id`,
                    `types`.`name` AS `type`,
                    `products`.`name`,
                    `presentations`.`content`,
                    `registers`.`deposit`,
                    `registers`.`liquor_shop`,
                    `registers`.`ordered`
                    " . $previousRegistersSQL['previousCount'] . "
                FROM
                    `registers`
                    INNER JOIN `products` ON `products`.`id` = `registers`.`product_id`
                    INNER JOIN `types` ON `types`.`id` = `products`.`type_id`
                    INNER JOIN `presentations` ON `presentations`.`id` = `products`.`presentation_id`
                    " . $previousRegistersSQL['leftJoin'] . "
                WHERE
                    `registers`.`id` IN ($identifiers)
            );

            -- Agrega las columnas cuyos datos se calculan a partir de las
            -- columnas que ya tenemos

            ALTER TABLE raw_registers ADD COLUMN total_count INT DEFAULT 0;
            ALTER TABLE raw_registers ADD COLUMN sales INT DEFAULT 0;

            -- Agrega los datos calculados a las nuevas columnas

            UPDATE raw_registers SET
                `total_count` = `deposit` + `liquor_shop`,
                `sales` = " . $previousRegistersSQL['sales'] . "
            WHERE `id` > 0;
        ");           
    }
}
