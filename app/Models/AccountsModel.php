<?php 
namespace App\Models;

use CodeIgniter\Model;

class AccountsModel extends Model {
    protected $table = "accounts";
    protected $primaryKey = "id";

    protected $returnType = "App\Entities\Accounts";
    protected $useSoftDeletes = false;

    protected $allowedFields = ["account_username", "account_password", "account_id", "account_name", "account_proxy", 
                                "account_profile", "account_challenge", "account_autocomplete", "account_choice", "account_status",
                                "account_used", "username_followers", "username_followings", "username_posts", "username_comments",
                                "username_likes", "hashtag_likes", "hashtag_comments", "hashtag_posts", "posts_likes",
                                "posts_comments", "username_data", "account_lastscraped", "account_fail_reason", "created_at", "updated_at"];

    protected $useTimestamps = false;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
    protected $dateFormat = "datetime";

    protected $validationRules = ["account_username" => "required", "account_password" => "required"];
    protected $validationMessages = [];
    protected $skipValidation = false;
}