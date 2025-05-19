<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SubmissionModel;
use App\Models\SubmissionHistoryModel;
use App\Models\DepartmentModel;
use App\Models\DocumentCategoryModel;

class Documents extends BaseController
{
    protected $submissionModel;
    protected $historyModel;
    protected $departmentModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->submissionModel = new SubmissionModel();
        $this->historyModel = new SubmissionHistoryModel();
        $this->departmentModel = new DepartmentModel();
        $this->categoryModel = new DocumentCategoryModel();
    }

    public function index()
    {
        // Get filter parameters
        $department_id = $this->request->getGet('department_id');
        $category_id = $this->request->getGet('category_id');
        $status = $this->request->getGet('status');
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');

        // Build query
        $builder = $this->submissionModel
            ->select('submissions.*, departments.name as department_name, document_categories.name as category_name, users.full_name as submitted_by')
            ->join('departments', 'departments.id = submissions.department_id')
            ->join('document_categories', 'document_categories.id = submissions.document_category_id')
            ->join('users', 'users.id = submissions.user_id');

        if ($department_id) {
            $builder->where('submissions.department_id', $department_id);
        }
        
        if ($category_id) {
            $builder->where('submissions.document_category_id', $category_id);
        }
        
        if ($status) {
            $builder->where('submissions.status', $status);
        }
        
        if ($start_date && $end_date) {
            $builder->where('DATE(submissions.submitted_at) >=', $start_date)
                ->where('DATE(submissions.submitted_at) <=', $end_date);
        }

        $submissions = $builder->orderBy('submissions.submitted_at', 'DESC')->findAll();

        $data = [
            'title' => 'Document Submissions',
            'submissions' => $submissions,
            'departments' => $this->departmentModel->findAll(),
            'categories' => $this->categoryModel->findAll(),
            'filters' => [
                'department_id' => $department_id,
                'category_id' => $category_id,
                'status' => $status,
                'start_date' => $start_date,
                'end_date' => $end_date
            ]
        ];

        return view('admin/documents/list', $data);
    }

    public function view($id)
    {
        $submission = $this->submissionModel->getSubmissionWithDetails($id);
        
        if (!$submission) {
            return redirect()->back()->with('error', 'Submission not found');
        }

        $data = [
            'title' => 'View Submission',
            'submission' => $submission
        ];

        return view('admin/documents/view', $data);
    }

    public function updateStatus($id)
    {
        $submission = $this->submissionModel->find($id);
        
        if (!$submission) {
            return redirect()->back()->with('error', 'Submission not found');
        }

        $newStatus = $this->request->getPost('status');
        $remarks = $this->request->getPost('remarks');

        // Validate status transition
        $validTransitions = [
            'pending' => ['reviewed'],
            'reviewed' => ['approved', 'rejected'],
            // Other transitions as needed
        ];

        if (isset($validTransitions[$submission['status']])) {
            if (!in_array($newStatus, $validTransitions[$submission['status']])) {
                return redirect()->back()->with('error', 'Invalid status transition');
            }
        }

        // Update status
        $this->submissionModel->update($id, [
            'status' => $newStatus,
            'remarks' => $remarks
        ]);

        // Log this action
        $this->historyModel->insert([
            'submission_id' => $id,
            'user_id' => session()->get('user_id'),
            'action' => 'status_change',
            'old_status' => $submission['status'],
            'new_status' => $newStatus,
            'remarks' => $remarks
        ]);

        return redirect()->to("/admin/documents/view/$id")->with('message', 'Status updated successfully');
    }

    public function history($id)
    {
        $submission = $this->submissionModel->find($id);
        
        if (!$submission) {
            return redirect()->back()->with('error', 'Submission not found');
        }

        $history = $this->historyModel->getHistoryForSubmission($id);

        $data = [
            'title' => 'Submission History',
            'submission' => $submission,
            'history' => $history
        ];

        return view('admin/documents/history', $data);
    }

    public function download($id)
    {
        $submission = $this->submissionModel->find($id);
        
        if (!$submission || !file_exists($submission['file_path'])) {
            return redirect()->back()->with('error', 'File not found');
        }

        return $this->response->download($submission['file_path'], null);
    }
}