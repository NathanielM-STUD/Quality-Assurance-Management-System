<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SubmissionModel;
use App\Models\DepartmentModel;
use App\Models\NotificationModel;

class Dashboard extends BaseController
{
    protected $submissionModel;
    protected $departmentModel;
    protected $notificationModel;

    public function __construct()
    {
        $this->submissionModel = new SubmissionModel();
        $this->departmentModel = new DepartmentModel();
        $this->notificationModel = new NotificationModel();
    }

    public function index()
    {
        // Get today's submissions
        $todaySubmissions = $this->submissionModel->where('DATE(submitted_at)', date('Y-m-d'))->countAllResults();
        
        // Get this month's submissions
        $monthSubmissions = $this->submissionModel->where('MONTH(submitted_at)', date('m'))->countAllResults();
        
        // Get submission status summary
        $statusSummary = $this->submissionModel->select('status, COUNT(*) as count')
            ->groupBy('status')
            ->findAll();
            
        // Get departments with most/least compliance
        $departmentsCompliance = $this->departmentModel->getDepartmentsWithCompliance();
        
        // Get recent notifications
        $notifications = $this->notificationModel->where('user_id', session()->get('user_id'))
            ->orderBy('created_at', 'DESC')
            ->findAll(5);

        $data = [
            'title' => 'Dashboard Overview',
            'todaySubmissions' => $todaySubmissions,
            'monthSubmissions' => $monthSubmissions,
            'statusSummary' => $statusSummary,
            'departmentsCompliance' => $departmentsCompliance,
            'notifications' => $notifications
        ];

        return view('admin/dashboard', $data);
    }

    public function reports()
    {
        $departments = $this->departmentModel->findAll();
        $categories = model('DocumentCategoryModel')->findAll();
        
        $data = [
            'title' => 'Reports & Analytics',
            'departments' => $departments,
            'categories' => $categories
        ];
        
        return view('admin/reports', $data);
    }

    public function generateReport()
    {
        $type = $this->request->getPost('report_type');
        $format = $this->request->getPost('format');
        $filters = [
            'department_id' => $this->request->getPost('department_id'),
            'category_id' => $this->request->getPost('category_id'),
            'status' => $this->request->getPost('status'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date')
        ];
        
        // Generate report based on type and format
        // This would typically call a report service
        // For now, we'll just show a simple example
        
        if ($format === 'pdf') {
            // Generate PDF using dompdf or similar
            return $this->generatePdfReport($filters);
        } else {
            // Generate Excel
            return $this->generateExcelReport($filters);
        }
    }
    
    protected function generatePdfReport($filters)
    {
        // Implement PDF generation logic
        // This is a placeholder
    }
    
    protected function generateExcelReport($filters)
    {
        // Implement Excel generation logic
        // This is a placeholder
    }
}