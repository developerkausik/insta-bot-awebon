<?php namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model {
    protected $table = "users";
    protected $primaryKey = "id";

    protected $returnType = "App\Entities\Users";
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        "first_name",
        "last_name",
        "account_type",
        "user_status",
        "user_ban_reason",
        "user_credits",
        "locked_credits",
        "email",
        "password",
		"profile_picture",
		"website",
        "created_at",
        "updated_at"
    ];

    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";

    protected $validationRules = ["email" => "required|valid_email", "password" => "required"];
    protected $validationMessages = ["email" => ['valid_email' => 'Invalid Email']];
    protected $skipValidation = false;
}