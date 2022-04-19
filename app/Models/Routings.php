<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Matrix\Operators\Operator;

class Routings extends Model
{
    use HasFactory;
    protected $table = 'routings';
    public $timestamps = true;
    protected $fillable = [
        'routing_id',
        'routing_name',
    ];

    public function routingOperations()
    {
        return $this->hasMany(RoutingOperation::class, 'routing_id', 'routing_id')->orderBy('sequence_id', 'asc');
    }

    public function operations()
    {
        $r_operations = $this->routingOperations;
        $operations = array();
        foreach ($r_operations as $ro) {
            array_push(
                $operations,
                array(
                    'operation' => Operation::where('operation_id', $ro->operation_id)->first(),
                    'operation_id' => $ro->operation_id,
                    'sequence_id' => $ro->sequence_id,
                    'hour_rate' => $ro->hour_rate,
                    'operation_time' => $ro->operation_time,
                    'operating_cost' => $ro->operating_cost
                )
            );
        }
        return $operations;
    }

    # use this instead
    public function operationsThrough()
    {
        return $this->hasManyThrough(
            Operation::class,
            RoutingOperation::class,
            'routing_id',
            'operation_id',
            'routing_id',
            'operation_id',
        )->orderBy('sequence_id', 'asc');
    }
}
