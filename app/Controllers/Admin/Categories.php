<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DocumentCategoryModel;

class Categories extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new DocumentCategoryModel();
    }

    public function index()
    {
        $categories = $this->categoryModel->findAll();

        $data = [
            'title' => 'Document Categories',
            'categories' => $categories
        ];

        return view('admin/categories/list', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Add New Document Category'
        ];

        return view('admin/categories/form', $data);
    }

    public function create()
    {
        $rules = [
            'name' => 'required|is_unique[document_categories.name]|max_length[100]',
            'description' => 'permit_empty|max_length[500]',
            'requirements' => 'required',
            'deadline_day' => 'permit_empty|numeric|between[1,31]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoryModel->insert([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'requirements' => $this->request->getPost('requirements'),
            'deadline_day' => $this->request->getPost('deadline_day')
        ]);

        return redirect()->to('/admin/categories')->with('message', 'Category added successfully');
    }

    public function edit($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }

        $data = [
            'title' => 'Edit Document Category',
            'category' => $category
        ];

        return view('admin/categories/form', $data);
    }

    public function update($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }

        $rules = [
            'name' => "required|is_unique[document_categories.name,id,$id]|max_length[100]",
            'description' => 'permit_empty|max_length[500]',
            'requirements' => 'required',
            'deadline_day' => 'permit_empty|numeric|between[1,31]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoryModel->update($id, [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'requirements' => $this->request->getPost('requirements'),
            'deadline_day' => $this->request->getPost('deadline_day')
        ]);

        return redirect()->to('/admin/categories')->with('message', 'Category updated successfully');
    }

    public function delete($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found');
        }

        // Check if category has submissions
        if (model('SubmissionModel')->where('document_category_id', $id)->countAllResults() > 0) {
            return redirect()->back()->with('error', 'Cannot delete category with existing submissions');
        }

        $this->categoryModel->delete($id);

        return redirect()->to('/admin/categories')->with('message', 'Category deleted successfully');
    }
}