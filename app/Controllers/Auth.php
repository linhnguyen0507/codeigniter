<?php

namespace App\Controllers;

use App\Libraries\Hash;
use App\Models\RoleModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException; // Add this line
use CodeIgniter\HTTP\Request;

class Auth extends BaseController
{
    protected $roleModel;
    public function __construct()
    {
        helper(['url', 'form']);
        $this->roleModel = new RoleModel();
    }
    public function view()
    {
        $page = $_SERVER['REQUEST_URI'];
        if (!is_file(APPPATH . 'Views/auth/' . $page . '.php')) {
            throw new PageNotFoundException($page);
        }


        return view('auth/' . $page);
    }
    public function login()
    {
        $validate = $this->validate([

            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Vui lòng nhập trường email.',
                    'valid_email' => 'Email không chính xác!'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[5]|max_length[20]',
                'errors' => [
                    'required' => 'Vui lòng nhập mật khẩu.',
                ]
            ],
        ]);
        if (!$validate) {
            return view('auth/login', ['validation' => $this->validator]);

        } else {
            $email = $this->request->getPost('email');

            $password = $this->request->getPost('password');
            $model = model(UserModel::class);
            $user = $model->where('email', $email)->first();
            if ($user) {
                if (!Hash::checkPassword($password, $user['password'])) {
                    return view('auth/login', ['login_fail' =>'Tài khoản hoặc mật khẩu không chính xác']);
                } else {
                    $role = model(RoleModel::class);
                    $roleuser = $role->getUserRole($user['id']);
                    $session = session();
                    $ss = [
                        'user_id' => $user['id'],
                    ];
                    $session->set($ss);
                    switch ($roleuser['role_name']) {
                        case 'admin':
                            return redirect()->to('/admin');
                        case 'member':
                            return redirect()->to('/member');
                        case 'leader':
                            return redirect()->to('/leader');
                        default:
                            # code...
                            break;
                    }
                    // return redirect()->to('/')
                }
            } else {
                return redirect()->back()->with('fail', 'Tài khoản hoặc mật khẩu sai!');
            }
        }
    }
    public function register()
    {

        $validate = $this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Vui lòng nhập trường tên người dùng.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Vui lòng nhập trường email.',
                    'valid_email' => 'Email không chính xác!'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[5]|max_length[20]',
                'errors' => [
                    'required' => 'Vui lòng nhập mật khẩu.',
                    'min_length' => 'Mật khẩu phải từ 5 - 20 kí tự.',
                    'max_length' => 'Mật khẩu không dài quá 20 kí tự.'
                ]
            ],
            'confirm' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Vui lòng nhập trường nhập lại mật khẩu.',
                    'matches' => 'Nhập lại mật khẩu không chính xác',
                ]
            ],
        ]);
        if (!$validate) {
            return view('auth/register', ['validation' => $this->validator]);
        }
        
        $newUser = new UserModel();
        $check = $newUser->getUser($this->request->getPost('email'));
        if (count($check) > 0) {
            
            return view('auth/register', ['validation_email' =>'Email đã tồn tại!']);
            
        }
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => Hash::encrypt($this->request->getPost('password')),
        ];
        $query = $newUser->insert($data);

        if (!$query) {
            return redirect()->back()->with('fail', 'Đăng kí không thành công');
        } else {
            $role = [
                'user_id' => $query,
            ];
            $newRole =  $this->roleModel->addRole($role);
            $session = session();
            $ss = [
                'user_id' => $query,
            ];
            $session->set($ss);
            return redirect()->to('/member')->with('success', $newRole);
        }
    }
}
