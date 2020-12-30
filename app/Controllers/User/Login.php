<?php namespace App\Controllers\User;

class Login extends PublicController
{
    public function index()
    {
        if ($this->session->LoggedIn == true) {
            $redirect = site_url() . "user/dashboard";
            $previousURL = get_cookie('last_page');
            if ($previousURL) {
                $redirect = $previousURL;
            } elseif ($this->request->getUserAgent()->isReferral()) {
                $redirect = $this->request->getUserAgent()->getReferrer();
            } elseif ($this->session->has('redirect') && $this->session->get('redirect') != site_url()) {
                $redirect = $this->session->get('redirect');
            }
            header('Location: '.$redirect);
            die();
        } else {
            $this->data["css"] = [
                "/assets/css/pages/login/login-3.css",
            ];
            $this->data["PageTitle"] = "Login";
            $this->data["content"] = "login/index";
        }
    }

    public function logout()
    {
        $this->session->destroy();
        $this->data["PageTitle"] = "Logout";
        $this->data["content"] = "login/logout";
        header("Location: " . base_url());
        die();
    }
}
