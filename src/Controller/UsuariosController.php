<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;

/**
 * Reportes Controller
 *
 * @property \App\Model\Table\ReportesTable $Reportes
 */
class UsuariosController extends AppController
{
    public function beforeFilter(Event $event) {
        $this->Auth->allow('login');
        $this->loadModel('Usuarios');
        $this->loadModel('Sucursales');
    }

    public function login() {

        $usuario = $this->getUsuario();

        if ($this->request->is('post')|| $usuario) {
            
            $usuario = $usuario ?? $this->Auth->identify();
            if ($usuario) {
                $this->Auth->setUser($usuario);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error('Usuario o contraseña incorrectos.');
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    public function usuarios() {
        $usuarios=$this->Usuarios->find()
        ->where(['activo'=>true]);

        $this->set(compact('usuarios'));
    }

    public function nuevo() {

        $user = $this->Usuarios->newEntity();

        $sucursales=$this->Sucursales->find()
        ->where(['status'=>true])
        ->order('nombre')
        ->toArray();

        $user->admin=false;

        $sucursal='';

        $this->set(compact('user','sucursales','sucursal'));
    }

    public function crear() {

        $usuario=$this->getusuario();

        $sucursal = $this->request->getData('sucursal');

        $nombre = $this->request->getData('nombre');
        $us = $this->request->getData('usuario');
        $password = $this->request->getData('password');
        $tipo = $this->request->getData('tipo') ?? 0;

        $caja = $this->request->getData('caja') ?? 0;
        $permiso_movimientos_caja = $this->request->getData('permiso_movimientos_caja') ?? 0;
        $permiso_nomina = $this->request->getData('permiso_nomina') ?? 0;
        $permiso_checador = $this->request->getData('permiso_checador') ?? 0;
        $permiso_proveedores = $this->request->getData('permiso_proveedores') ?? 0;
        $permiso_reparaciones = $this->request->getData('permiso_reparaciones') ?? 0; 
        $permiso_cobranzas = $this->request->getData('permiso_cobranzas') ?? 0; 

        $nombre = ucwords(strtolower($nombre));

        $usuario_existente = $this->Usuarios->find()
        ->where(['usuario' => $us])
        ->first();
        if ($usuario_existente)
        {
            $this->Flash->error('Ya existe un Usuario con ese nombre: ' . $nombre);
            $this->redirect(['action' => 'nuevo']);
            return;
        }

        $user = $this->Usuarios->newEntity();
        $user->nombre=$nombre;
        $user->usuario=$us;
        $user->password=$password;
        $user->admin=$tipo;
        $user->activo=true;
        $user->caja=$caja;
        $user->nominas=$permiso_nomina;
        $user->checador=$permiso_checador;
        $user->movimientos_caja=$permiso_movimientos_caja;
        $user->proveedores=$permiso_proveedores;
        $user->reparaciones=$permiso_reparaciones;
        $user->cobranzas=$permiso_cobranzas;
        $user->sucursal_id=$sucursal;

        if($nombre=="" || $usuario=="" || $password=="")
        {
            $this->Flash->default("Necesita llenar todos los campos");
            $this->redirect(['action' => 'nuevo']); 
        }
        else
        {
            $this->Usuarios->save($user);

            $this->Flash->default("Se creó el Usuario: ".$us." , Exitosamente.");
            $this->redirect(['action' => 'usuarios']); 
        }
    }

    public function editar() {

        $user = $this->Usuarios->get($this->request->getQuery('id'));

        $sucursales=$this->Sucursales->find()
        ->where(['status'=>true])
        ->order('nombre')
        ->toArray();

        $sucursal=$user->sucursal_id;
        
        $this->set(compact('user','sucursales','sucursal'));
    }

    public function actualizar() {

        $user = $this->Usuarios->get($this->request->getQuery('id'));

        $sucursal = $this->request->getData('sucursal');

        $nombres = $this->request->getData('nombre') ?? '';
        $usuario = $this->request->getData('usuario') ?? '';
        $password = $this->request->getData('password');
        $tipo = $this->request->getData('tipo');

        $caja = $this->request->getData('caja') ?? 0;
        $permiso_movimientos_caja = $this->request->getData('permiso_movimientos_caja') ?? 0;
        $permiso_nomina = $this->request->getData('permiso_nomina') ?? 0;
        $permiso_checador = $this->request->getData('permiso_checador') ?? 0;
        $permiso_cobranzas = $this->request->getData('permiso_cobranzas') ?? 0;
        $permiso_proveedores = $this->request->getData('permiso_proveedores') ?? 0;
        $permiso_reparaciones = $this->request->getData('permiso_reparaciones') ?? 0;
        
        $nombres = ucwords(strtolower($nombres));
        
        $user->nombre=$nombres;
        $user->usuario=$user;
        $user->password=$password;
        $user->admin=$tipo;

        
        $user->nombre=$nombres;
        $user->usuario=$usuario;
        $user->password=$password;
        $user->admin=$tipo;
        $user->activo=true;
        $user->caja=$caja;
        $user->nominas=$permiso_nomina;
        $user->checador=$permiso_checador;
        $user->movimientos_caja=$permiso_movimientos_caja;
        $user->cobranzas=$permiso_cobranzas;
        $user->reparaciones=$permiso_reparaciones;
        $user->proveedores=$permiso_proveedores;
        $user->sucursal_id=$sucursal;



        if ($this->request->is('post'))
        {
            if($this->Usuarios->save($user))
             {
                $this->Flash->default("Se actualizo al usuario ".$nombres." exitosamente.");
                $this->redirect(['action' => 'usuarios']);
             }
             else
             {
               $this->Flash->error("Hubo un Error al Actualizar el Empleado.");
               $this->redirect(['action' => 'editar']);
             }
        }
    }

    public function eliminar() {

        if ($this->Usuarios->get($this->request->getQuery('id'))) 
        {
            $usuario = $this->Usuarios->get($this->request->getQuery('id'));
            $usuario->activo=0;

            $this->Usuarios->save($usuario);

            $this->Flash->default("Se elimino el Usuario exitosamente.");
            $this->redirect(['action' => 'usuarios']);
        }
        else
        {
            $this->Flash->default("no");
            $this->redirect(['action' => 'usuarios']);
        }
    }
}