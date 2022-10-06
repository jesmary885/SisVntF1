<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Usuario']);

        //MODULO ADMINISTRACION

        Permission::create(['name' => 'admin.clientes.index',
                            'description' => 'Administrar clientes'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.usuarios.index',
                            'description' => 'Administrar usuarios'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.roles.index',
                            'description' => 'Administrar roles y permisos'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.compras.index',
                            'description' => 'Administrar compras'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.sucursales.index',
                            'description' => 'Administrar sucursales'])->syncRoles([$role1]); 
        
        Permission::create(['name' => 'admin.proveedores.index',
                            'description' => 'Administrar proveedores'])->syncRoles([$role1]); 

        Permission::create(['name' => 'admin.categorias.index',
                            'description' => 'Administrar categorias'])->syncRoles([$role1]); 

        Permission::create(['name' => 'admin.marcas.index',
                            'description' => 'Administrar marcas'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.modelos.index',
                            'description' => 'Administrar modelos'])->syncRoles([$role1]);
    
        Permission::create(['name' => 'admin.index.cajas',
                            'description' => 'Administrar cajas'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.index.metodos',
                            'description' => 'Administrar metodos de pago'])->syncRoles([$role1]);

        //TASA DE CAMBIO
        Permission::create(['name' => 'admin.tasa.index',
                            'description' => 'Mostrar tasa de cambio'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.tasa.edit',
                            'description' => 'Editar tasa de cambio'])->syncRoles([$role1]);

        //MODULO VENTAS

        Permission::create(['name' => 'ventas.ventas.index',
                            'description' => 'Registrar ventas'])->syncRoles([$role1]);

        Permission::create(['name' => 'ventas.mostrar_ventas_contado',
                            'description' => 'Ver y administrar ventas al contado'])->syncRoles([$role1]);

        Permission::create(['name' => 'ventas.mostrar_ventas_credito',
                            'description' => 'Ver y administrar ventas a credito'])->syncRoles([$role1]);

        Permission::create(['name' => 'ventas.mostrar_ventas_clientes',
                            'description' => 'Ver y administrar ventas por cliente'])->syncRoles([$role1]);

        //MODULO PROFORMAS

        Permission::create(['name' => 'proformas.proformas.index',
        'description' => 'Registrar proformas'])->syncRoles([$role1]);

        Permission::create(['name' => 'proformas.mostrar_proformas',
        'description' => 'Ver proformas registradas'])->syncRoles([$role1]);

         //MODULO MOVIMIENTOS

         Permission::create(['name' => 'movimientos_caja.index',
         'description' => 'Ver y registrar movimientos de caja'])->syncRoles([$role1]);
         Permission::create(['name' => 'movimientos_caja_pendiente.index',
         'description' => 'Movimientos pendientes en caja'])->syncRoles([$role1]);
 
       



        //MODULO PRODUCTOS
                            

        Permission::create(['name' => 'productos.productos.index',
            'description' => 'Administrar productos por código de barra'])->syncRoles([$role1,$role2]);

        Permission::create(['name' => 'productos.index_serial',
            'description' => 'Administrar productos por serial'])->syncRoles([$role1]);

        Permission::create(['name' => 'productos.productos.delete',
            'description' => 'Eliminar productos'])->syncRoles([$role1,$role2]);

        Permission::create(['name' => 'productos.devolucion',
            'description' => 'Administrar devolución de equipos'])->syncRoles([$role1]);

        Permission::create(['name' => 'productos.traslado',
            'description' => 'Administrar traslado de equipos'])->syncRoles([$role1]);

        Permission::create(['name' => 'productos.lotes.index',
            'description' => 'Administrar productos por lote'])->syncRoles([$role1]);
        
        Permission::create(['name' => 'productos.lotes.delete',
            'description' => 'Eliminar lotes'])->syncRoles([$role1]);

        //MODULO REPORTES
                            

        Permission::create(['name' => 'reportes.productos',
        'description' => 'Generar reportes de productos más vendidos'])->syncRoles([$role1,$role2]);

        Permission::create(['name' => 'reportes.movimientos',
        'description' => 'Generar kardex'])->syncRoles([$role1]);

        Permission::create(['name' => 'reportes.ventas',
        'description' => 'Generar reportes de ventas'])->syncRoles([$role1]);

        Permission::create(['name' => 'reportes.desactivados',
        'description' => 'Administrar productos desactivados por traslado'])->syncRoles([$role1]);

        Permission::create(['name' => 'reportes.movimientos_caja',
        'description' => 'Generar reportes de movimientos en cajas'])->syncRoles([$role1]);

        Permission::create(['name' => 'reportes.traslados',
        'description' => 'Generar reportes de traslados'])->syncRoles([$role1]);

         
        //MODULO AJUSTES
                            

         Permission::create(['name' => 'ajustes.contrasena',
         'description' => 'Cambiar contraseña'])->syncRoles([$role1,$role2]);
 
         Permission::create(['name' => 'ajustes.empresa',
         'description' => 'Administrar datos de empresa'])->syncRoles([$role1]);

         Permission::create(['name' => 'apertura-caja.index',
         'description' => 'Aperturar y cerrar cajas'])->syncRoles([$role1,$role2]);
 


    }
}
