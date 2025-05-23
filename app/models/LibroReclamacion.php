<?php

namespace App\Models;

use Carbon\Carbon;

class LibroReclamacion extends Model
{
    /**
     * Nombre de la tabla
     * @var string
     */
    protected $table = 'libro_reclamaciones';

    /**
     * Los atributos que son asignables masivamente
     * @var array
     */
    protected $fillable = [
        'tipo_documento',
        'numero_documento',
        'nombres_apellidos',
        'menor_edad',
        'apoderado',
        'direccion',
        'correo',
        'telefono',
        'fecha_incidente',
        'bien_contratado',
        'descripcion_bien',
        'tipo_incidente',
        'monto',
        'detalle',
        'pedido_consumidor',
        'estado',
        'respuesta',
        'fecha_respuesta'
    ];

    /**
     * Los atributos que deben ser casteados a tipos nativos
     * @var array
     */
    protected $casts = [
        'menor_edad' => 'boolean',
        'fecha_incidente' => 'date',
        'fecha_respuesta' => 'date',
        'monto' => 'decimal:2'
    ];

    /**
     * Indica si el modelo debe ser timestamped
     * @var bool
     */
    public $timestamps = true;

    /**
     * Método para crear una nueva reclamación
     */
    public static function crearReclamacion($datos)
    {
        return self::create([
            'tipo_documento' => $datos['tipo_documento'],
            'numero_documento' => $datos['numero_documento'],
            'nombres_apellidos' => $datos['nombres_apellidos'],
            'menor_edad' => $datos['menor_edad'] ?? false,
            'apoderado' => !empty($datos['apoderado']) ? $datos['apoderado'] : null,
            'direccion' => $datos['direccion'],
            'correo' => $datos['correo'],
            'telefono' => !empty($datos['telefono']) ? $datos['telefono'] : null,
            'fecha_incidente' => $datos['fecha_incidente'],
            'bien_contratado' => $datos['bien_contratado'],
            'descripcion_bien' => $datos['descripcion_bien'],
            'tipo_incidente' => $datos['tipo_incidente'],
            'monto' => !empty($datos['monto']) ? (float)$datos['monto'] : null,
            'detalle' => $datos['detalle'],
            'pedido_consumidor' => $datos['pedido_consumidor'],
            'estado' => 'Pendiente'
        ]);
    }

    /**
     * Método para obtener todas las reclamaciones
     */
    public static function obtenerTodas()
    {
        return self::orderBy('created_at', 'desc')->get();
    }

    /**
     * Método para obtener reclamaciones por estado
     */
    public static function obtenerPorEstado($estado)
    {
        return self::where('estado', $estado)
                   ->orderBy('created_at', 'desc')
                   ->get();
    }

    /**
     * Método para responder una reclamación
     */
    public function responder($respuesta, $nuevoEstado)
    {
        $this->update([
            'respuesta' => $respuesta,
            'estado' => $nuevoEstado,
            'fecha_respuesta' => Carbon::now()
        ]);
    }

    /**
     * Método para verificar si la reclamación está pendiente
     */
    public function estaPendiente()
    {
        return $this->estado === 'Pendiente';
    }

    /**
     * Método para verificar si la reclamación está resuelta
     */
    public function estaResuelta()
    {
        return $this->estado === 'Resuelto';
    }
}
