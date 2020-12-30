<?php 
namespace App\Entities;

use CodeIgniter\Entity;

class Accounts extends Entity
{
    protected $account_username;
    protected $account_password;
    protected $account_id;
    protected $account_name;
    protected $account_proxy;
    protected $account_profile;
    protected $account_challenge;
    protected $account_autocomplete;
    protected $account_choice;
    protected $account_used;
    protected $username_followers;
    protected $username_followings;
    protected $username_posts;
    protected $username_comments;
    protected $username_likes;
    protected $hashtag_likes;
    protected $hashtag_comments;
    protected $hashtag_posts;
    protected $posts_likes;
    protected $posts_comments;
    protected $username_data;
    protected $account_lastscraped;
    protected $account_fail_reason;
    protected $created_at;
    protected $updated_at;
}