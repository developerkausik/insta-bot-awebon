<?php namespace App\Controllers\User;

use App\Controllers\BaseController;

class UserController extends BaseController
{
    public function __destruct()
    {
        $request = \Config\Services::request();
        $segments = $request->uri->getSegments();
        $segment = $segments[0];
        $this->data['Segments'] = $segments;
        $data = $this->data;

        if (isset($this->data['content']) &&_($path = $this->data['content'])) {
            echo view("template/header", $this->data);
            
            echo view($path . "/index", $this->data);
            
            echo view("template/footer", $this->data);
            
            if (file_exists(APPPATH . "Views/" . $path . "/footer.php")) {
                echo view($path . "/footer", $this->data);
            }
        }
    }
}
