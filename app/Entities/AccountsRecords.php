<?php 
namespace App\Entities;

use CodeIgniter\Entity;

class AccountsRecords extends Entity
{
    protected $account_id;
    protected $username_followers;
    protected $username_followers_date;
    protected $username_followings;
    protected $username_followings_date;
    protected $username_posts;
    protected $username_posts_date;
    protected $username_likes;
    protected $username_likes_date;
    protected $username_comments;
    protected $username_comments_date;
    protected $hashtag_posts;
    protected $hashtag_posts_date;
    protected $hashtag_comments;
    protected $hashtag_comments_date;
    protected $hashtag_likes;
    protected $hashtag_likes_date;
    protected $location_posts;
    protected $location_posts_date;
    protected $location_comments;
    protected $location_comments_date;
    protected $location_likes;
    protected $location_likes_date;
    protected $post_comments;
    protected $post_comments_date;
    protected $post_likes;
    protected $post_likes_date;
    protected $created_at;
    protected $updated_at;
}