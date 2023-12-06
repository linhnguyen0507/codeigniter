<?php

namespace App\Filters;

use App\Models\RoleModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login');
        }
        $arguments = $arguments ?? '';
        $session = session();
        $user_id = $session->get('user_id');
        $model = model(RoleModel::class);
        $role = $model->getUserRole($user_id);
        if (!$this->hasPermission($role['role_name'], $request->uri->getSegment(1))) {
            return redirect()->to('/404');
        }

        return $request;
    }
  
    protected function hasPermission($role, $segment)
    {
        if ($role === 'admin') {
            return true;
        }
        switch ($segment) {
            case 'admin':
                return $role === 'admin'; 
            case 'leader':
                return in_array($role, ['admin', 'leader']); 
            case 'member':
                return in_array($role, ['admin', 'leader', 'member']);
            default:
                return false; 
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}