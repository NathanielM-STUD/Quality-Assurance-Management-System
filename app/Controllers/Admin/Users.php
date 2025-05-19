<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\DepartmentModel;

class Users extends BaseController
{
    protected $userModel;
    protected $departmentModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->departmentModel = new DepartmentModel();
    }

    public function index()
    {
        $users = $this->userModel->getUsersWithDepartments();

        $data = [
            'title' => 'Manage Users',
            'users' => $users
        ];

        return view('admin/users/list', $data);
    }

    public function new()
    {
        $departments = $this->departmentModel->findAll();

        $data = [
            'title' => 'Add New User',
            'departments' => $departments
        ];

        return view('admin/users/form', $data);
    }

    public function create()
    {
        $rules = [
            'username' => 'required|is_unique[users.username]|max_length[50]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'full_name' => 'required|max_length[100]',
            'password' => 'required|min_length[8]',
            'role' => 'required|in_list[admin,representative]',
            'department_id' => 'permit_empty|is_not_unique[departments.id]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'department_id' => $this->request->getPost('department_id')
        ];

        $this->userModel->insert($data);

        return redirect()->to('/admin/users')->with('message', 'User added successfully');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $departments = $this->departmentModel->findAll();

        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'departments' => $departments
        ];

        return view('admin/users/form', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        $rules = [
            'username' => "required|is_unique[users.username,id,$id]|max_length[50]",
            'email' => "required|valid_email|is_unique[users.email,id,$id]",
            'full_name' => 'required|max_length[100]',
            'role' => 'required|in_list[admin,representative]',
            'department_id' => 'permit_empty|is_not_unique[departments.id]'
        ];

        // Only validate password if it's provided
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[8]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
            'role' => $this->request->getPost('role'),
            'department_id' => $this->request->getPost('department_id')
        ];

        // Update password only if provided
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);

        return redirect()->to('/admin/users')->with('message', 'User updated successfully');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Prevent deleting own account
        if ($user['id'] == session()->get('user_id')) {
            return redirect()->back()->with('error', 'You cannot delete your own account');
        }

        $this->userModel->delete($id);

        return redirect()->to('/admin/users')->with('message', 'User deleted successfully');
    }

    public function resetPassword($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Generate a random password
        $newPassword = bin2hex(random_bytes(4)); // 8 character password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $this->userModel->update($id, ['password' => $hashedPassword]);

        // In a real app, you would email the new password to the user
        // For this example, we'll just return it (not secure for production)
        return redirect()->to('/admin/users')->with('message', "Password reset successfully. New password: $newPassword");
    }
}