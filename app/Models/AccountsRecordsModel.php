<?php 
namespace App\Models;

use CodeIgniter\Model;

class AccountsRecordsModel extends Model {
    protected $table = "accounts_records";
    protected $primaryKey = "id";

    protected $returnType = "App\Entities\AccountsRecords";
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        "account_id",
        "username_followers",
        "username_followers_date",
        "username_followings",
        "username_followings_date",
        "username_posts",
        "username_posts_date",
        "username_likes",
        "username_likes_date",
        "username_comments",
        "username_comments_date",
        "hashtag_posts",
        "hashtag_posts_date",
        "hashtag_comments",
        "hashtag_comments_date",
        "hashtag_likes",
        "hashtag_likes_date",
        "location_posts",
        "location_posts_date",
        "location_comments",
        "location_comments_date",
        "location_likes",
        "location_likes_date",
        "post_comments",
        "post_comments_date",
        "post_likes",
        "post_likes_date",
        "created_at",
        "updated_at"
    ];

    protected $useTimestamps = true;
    protected $createdField = "created_at";
    protected $updatedField = "updated_at";
}