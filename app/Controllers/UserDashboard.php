<?php

namespace App\Controllers;

use App\Models\DocumentCategoryModel;
use App\Models\SubmissionModel;
use App\Models\NotificationModel;
use App\Models\UserModel;
use App\Models\DepartmentModel;

class UserDashboard extends BaseController
{
    protected $documentCategoryModel;
    protected $submissionModel;
    protected $notificationModel;
    protected $userModel;
    protected $departmentModel;

    public function __construct()
    {
        $this->documentCategoryModel = new DocumentCategoryModel();
        $this->submissionModel = new SubmissionModel();
        $this->notificationModel = new NotificationModel();
        $this->userModel = new UserModel();
        $this->departmentModel = new DepartmentModel();
        
        helper(['form', 'url', 'date']);
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('id');
        $data = [
            'title' => 'User Dashboard',
            'totalSubmissions' => $this->submissionModel->where('user_id', $userId)->countAllResults(),
            'statusSummary' => $this->submissionModel->getStatusSummary($userId),
            'upcomingRequirements' => $this->documentCategoryModel->getUpcomingRequirements(),
            'notifications' => $this->notificationModel->where('user_id', $userId)
                                                      ->orderBy('created_at', 'DESC')
                                                      ->findAll(5),
            'recentSubmissions' => $this->submissionModel->where('user_id', $userId)
                                                        ->orderBy('submitted_at', 'DESC')
                                                        ->findAll(5)
        ];

        return view('user/dashboard', $data);
    }

    public function submissions()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('id');
        $data = [
            'title' => 'My Submissions',
            'submissions' => $this->submissionModel->getUserSubmissionsWithDetails($userId)
        ];

        return view('user/submissions', $data);
    }

    public function submitDocument()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Submit Document',
            'categories' => $this->documentCategoryModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('user/submit_document', $data);
    }

    public function saveSubmission()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $rules = [
            'document_category_id' => 'required|numeric',
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'permit_empty|max_length[500]',
            'document' => 'uploaded[document]|max_size[document,5120]|ext_in[document,pdf,doc,docx]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('document');
        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads', $newName);

        $data = [
            'document_category_id' => $this->request->getPost('document_category_id'),
            'department_id' => session()->get('department_id'),
            'user_id' => session()->get('id'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'file_path' => $newName,
            'status' => 'pending'
        ];

        if ($this->submissionModel->save($data)) {
            return redirect()->to('/user/submissions')->with('message', 'Document submitted successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to submit document. Please try again.');
        }
    }

    public function resubmitDocument($submissionId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $submission = $this->submissionModel->find($submissionId);
        if (!$submission || $submission['user_id'] != session()->get('id') || $submission['status'] != 'rejected') {
            return redirect()->to('/user/submissions')->with('error', 'Invalid submission for resubmission.');
        }

        $data = [
            'title' => 'Resubmit Document',
            'submission' => $submission,
            'categories' => $this->documentCategoryModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('user/resubmit_document', $data);
    }

    public function updateSubmission($submissionId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $submission = $this->submissionModel->find($submissionId);
        if (!$submission || $submission['user_id'] != session()->get('id') || $submission['status'] != 'rejected') {
            return redirect()->to('/user/submissions')->with('error', 'Invalid submission for resubmission.');
        }

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'description' => 'permit_empty|max_length[500]',
            'document' => 'uploaded[document]|max_size[document,5120]|ext_in[document,pdf,doc,docx]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('document');
        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads', $newName);

        // Delete old file
        if (file_exists(WRITEPATH . 'uploads/' . $submission['file_path'])) {
            unlink(WRITEPATH . 'uploads/' . $submission['file_path']);
        }

        $data = [
            'id' => $submissionId,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'file_path' => $newName,
            'status' => 'pending',
            'remarks' => null,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->submissionModel->save($data)) {
            // Add to submission history
            $historyData = [
                'submission_id' => $submissionId,
                'user_id' => session()->get('id'),
                'action' => 'resubmitted',
                'old_status' => 'rejected',
                'new_status' => 'pending',
                'remarks' => 'User resubmitted the document'
            ];
            $this->submissionModel->addHistory($historyData);

            return redirect()->to('/user/submissions')->with('message', 'Document resubmitted successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to resubmit document. Please try again.');
        }
    }

    public function requirements()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Document Requirements',
            'categories' => $this->documentCategoryModel->findAll()
        ];

        return view('user/requirements', $data);
    }

    public function notifications()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('id');
        $this->notificationModel->where('user_id', $userId)->set('is_read', 1)->update();

        $data = [
            'title' => 'Notifications',
            'notifications' => $this->notificationModel->where('user_id', $userId)
                                                     ->orderBy('created_at', 'DESC')
                                                     ->findAll()
        ];

        return view('user/notifications', $data);
    }

    public function profile()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('id');
        $data = [
            'title' => 'My Profile',
            'user' => $this->userModel->find($userId),
            'departments' => $this->departmentModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('user/profile', $data);
    }

    public function updateProfile()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('id');
        $rules = [
            'full_name' => 'required|min_length[3]|max_length[100]',
            'department_id' => 'permit_empty|numeric'
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]|max_length[255]';
            $rules['password_confirm'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id' => $userId,
            'full_name' => $this->request->getPost('full_name'),
            'department_id' => $this->request->getPost('department_id')
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        if ($this->userModel->save($data)) {
            // Update session data if name changed
            if (session()->get('full_name') != $data['full_name']) {
                session()->set('full_name', $data['full_name']);
            }
            if (session()->get('department_id') != $data['department_id']) {
                session()->set('department_id', $data['department_id']);
            }

            return redirect()->to('/user/profile')->with('message', 'Profile updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update profile. Please try again.');
        }
    }

    public function downloadTemplate($categoryId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $category = $this->documentCategoryModel->find($categoryId);
        if (!$category) {
            return redirect()->back()->with('error', 'Invalid document category.');
        }

        $templatePath = WRITEPATH . 'templates/' . $categoryId . '.docx';
        if (!file_exists($templatePath)) {
            return redirect()->back()->with('error', 'Template not available for this document type.');
        }

        return $this->response->download($templatePath, null);
    }

    public function downloadSubmission($submissionId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $submission = $this->submissionModel->find($submissionId);
        if (!$submission || $submission['user_id'] != session()->get('id')) {
            return redirect()->back()->with('error', 'Invalid submission or not authorized.');
        }

        $filePath = WRITEPATH . 'uploads/' . $submission['file_path'];
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return $this->response->download($filePath, null);
    }
}