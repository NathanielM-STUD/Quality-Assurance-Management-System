<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function login()
    {
        // If user is already logged in, redirect to dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to(session()->get('role') === 'admin' ? '/admin/dashboard' : '/user/dashboard');
        }

        $data = [
            'title' => 'Login',
            'validation' => \Config\Services::validation()
        ];

        return view('auth/login', $data);
    }

    public function attemptLogin()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('username', $username)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid username or password');
        }

        // Set user session
        $sessionData = [
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'full_name' => $user['full_name'],
            'role' => $user['role'],
            'department_id' => $user['department_id'],
            'isLoggedIn' => true
        ];

        session()->set($sessionData);

        // Redirect based on role
        return redirect()->to($user['role'] === 'admin' ? '/admin/dashboard' : '/user/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function forgotPassword()
    {
        $data = [
            'title' => 'Forgot Password',
            'validation' => \Config\Services::validation()
        ];

        return view('auth/forgot_password', $data);
    }

    public function sendResetLink()
    {
        $rules = [
            'email' => 'required|valid_email'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $user = $this->userModel->where('email', $email)->first();

        if ($user) {
            // Generate reset token (in a real app, you'd send this via email)
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $this->userModel->update($user['id'], [
                'reset_token' => $token,
                'reset_expiry' => $expiry
            ]);

            // In a real application, you would send an email here with the reset link
            // For this example, we'll just show the token
            return redirect()->to('/login')->with('message', 'Password reset link has been sent to your email (simulated). Token: ' . $token);
        }

        return redirect()->back()->with('error', 'Email not found in our system');
    }

    public function resetPassword($token = null)
    {
        if (!$token) {
            return redirect()->to('/forgot-password');
        }

        $user = $this->userModel->where('reset_token', $token)
                               ->where('reset_expiry >', date('Y-m-d H:i:s'))
                               ->first();

        if (!$user) {
            return redirect()->to('/forgot-password')->with('error', 'Invalid or expired reset token');
        }

        $data = [
            'title' => 'Reset Password',
            'token' => $token,
            'validation' => \Config\Services::validation()
        ];

        return view('auth/reset_password', $data);
    }

    public function updatePassword($token)
    {
        $rules = [
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $this->userModel->where('reset_token', $token)
                               ->where('reset_expiry >', date('Y-m-d H:i:s'))
                               ->first();

        if (!$user) {
            return redirect()->to('/forgot-password')->with('error', 'Invalid or expired reset token');
        }

        $this->userModel->update($user['id'], [
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'reset_token' => null,
            'reset_expiry' => null
        ]);

        return redirect()->to('/login')->with('message', 'Password has been reset successfully');
    }
}