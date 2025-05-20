<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DepartmentModel;
use App\Models\UserModel;

class Departments extends BaseController
{
    protected $departmentModel;
    protected $userModel;

    public function __construct()
    {
        $this->departmentModel = new DepartmentModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $departments = $this->departmentModel->getDepartmentsWithRepresentatives();

        $data = [
            'title' => 'Manage Departments',
            'departments' => $departments
        ];

        return view('admin/departments/list', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Add New Department'
        ];

        return view('admin/departments/create', $data);
    }

    public function create()
    {
        $rules = [
            'name' => 'required|is_unique[departments.name]|max_length[100]',
            'description' => 'permit_empty|max_length[500]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->departmentModel->insert([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ]);

        return redirect()->to('/admin/departments')->with('message', 'Department added successfully');
    }

    public function edit($id)
    {
        $department = $this->departmentModel->find($id);
        
        if (!$department) {
            return redirect()->back()->with('error', 'Department not found');
        }

        $representatives = $this->userModel->where('department_id', $id)
            ->where('role', 'representative')
            ->findAll();

        $data = [
            'title' => 'Edit Department',
            'department' => $department,
            'representatives' => $representatives
        ];

        return view('admin/departments/edit', $data);
    }

    public function update($id)
    {
        $department = $this->departmentModel->find($id);
        
        if (!$department) {
            return redirect()->back()->with('error', 'Department not found');
        }

        $rules = [
            'name' => "required|is_unique[departments.name,id,$id]|max_length[100]",
            'description' => 'permit_empty|max_length[500]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->departmentModel->update($id, [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ]);

        return redirect()->to('/admin/departments')->with('message', 'Department updated successfully');
    }

    public function delete($id)
    {
        $department = $this->departmentModel->find($id);
        
        if (!$department) {
            return redirect()->back()->with('error', 'Department not found');
        }

        // Check if department has users
        $hasUsers = $this->userModel->where('department_id', $id)->countAllResults() > 0;
        
        if ($hasUsers) {
            return redirect()->back()->with('error', 'Cannot delete department with assigned users');
        }

        $this->departmentModel->delete($id);

        return redirect()->to('/admin/departments')->with('message', 'Department deleted successfully');
    }
}