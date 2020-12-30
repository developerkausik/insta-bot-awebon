<?php

function delete_session($username)
{
    $dir = ROOTPATH . 'app/Vendors/mgp25/instagram-php/sessions/'.$username;

    if (file_exists($dir)) {
        foreach(scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
            else unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    return true;
}

function get_user_model($Capitalized = false)
{
    $Fields = [
        'username'                            => 'string',
        //'has_anonymous_profile_picture'       => 'bool',
        //'is_favorite'                         => 'bool',
        'profile_pic_url'                     => 'string',
        'profile_pic_id'                      => 'string',
        'full_name'                           => 'string',
        //'user_id'                             => 'string',
        'pk'                                  => 'string',
        //'id'                                  => 'string',
        'is_verified'                         => 'bool',
        'is_private'                          => 'bool',
        //'coeff_weight'                        => '',
        //'friendship_status'                   => 'FriendshipStatus',
        //'hd_profile_pic_versions'             => 'ImageCandidate[]',
        //'byline'                              => '',
        //'search_social_context'               => '',
        //'unseen_count'                        => '',
        //'mutual_followers_count'              => '',
        //'follower_count'                      => 'int',
        //'social_context'                      => 'string',
        //'media_count'                         => 'int',
        //'following_count'                     => 'int',
        'is_business'                         => 'bool',
        //'usertags_count'                      => 'int',
        //'profile_context'                     => '',
        'biography'                           => 'string',
        //'geo_media_count'                     => 'int',
        //'is_unpublished'                      => 'bool',
        //'allow_contacts_sync'                 => '',
        //'show_feed_biz_conversion_icon'       => '',
        //'auto_expand_chaining'                => '',
        //'can_boost_post'                      => '',
        //'is_profile_action_needed'            => 'bool',
        //'has_chaining'                        => 'bool',
        //'chaining_suggestions'                => 'ChainingSuggestion[]',
        //'include_direct_blacklist_status'     => '',
        //'can_see_organic_insights'            => '',
        //'can_convert_to_business'             => '',
        //'convert_from_pages'                  => '',
        //'show_business_conversion_icon'       => '',
        //'show_conversion_edit_entry'          => 'bool',
        //'show_insights_terms'                 => '',
        //'can_create_sponsor_tags'             => '',
        //'hd_profile_pic_url_info'             => 'ImageCandidate',
        //'usertag_review_enabled'              => '',
        //'profile_context_mutual_follow_ids'   => 'string[]',
        //'profile_context_links_with_user_ids' => 'Link[]',
        //'has_biography_translation'           => 'bool',
        //'can_link_entities_in_bio'            => 'bool',
        //'max_num_linked_entities_in_bio'      => 'int',
        //'business_contact_method'             => 'string',
        /*
         * Business category.
         */
        'category'                            => 'string',
        //'direct_messaging'                    => 'string',
        //'page_name'                           => '',
        //'fb_page_call_to_action_id'           => 'string',
        //'is_call_to_action_enabled'           => 'bool',
        'public_phone_country_code'           => 'string',
        'public_phone_number'                 => 'string',
        'contact_phone_number'                => 'string',
        //'latitude'                            => 'float',
        //'longitude'                           => 'float',
        //'address_street'                      => 'string',
        //'zip'                                 => 'string',
        //'city_id'                             => 'string', // 64-bit number.
        //'city_name'                           => 'string',
        'public_email'                        => 'string',
        //'is_needy'                            => 'bool',
        'external_url'                        => 'string',
        'external_lynx_url'                   => 'string',
        //'email'                               => 'string',
        //'country_code'                        => 'int',
        //'birthday'                            => '',
        //'national_number'                     => 'string', // Really int, but may be >32bit.
        //'gender'                              => 'int',
        //'phone_number'                        => 'string',
        //'needs_email_confirm'                 => '',
        //'is_active'                           => 'bool',
        //'block_at'                            => '',
        //'aggregate_promote_engagement'        => '',
        //'fbuid'                               => '',
        //'page_id'                             => 'string',
        /*
         * Unix "taken_at" timestamp of the newest item in their story reel.
         */
        //'latest_reel_media'                   => 'string',
        //'has_unseen_besties_media'            => 'bool',
        //'allowed_commenter_type'              => '',
        //'reel_auto_archive'                   => 'string',
        //'besties_count'                       => 'int',
        //'can_be_tagged_as_sponsor'            => 'bool',
        //'can_follow_hashtag'                  => 'bool',
        //'has_profile_video_feed'              => 'bool',
        //'is_video_creator'                    => 'bool',
        //'show_besties_badge'                  => 'bool',
        //'screenshotted'                       => 'bool',
        /*
         * Additional Fields
         */
        'regex_email'                           =>  'string',
        'regex_phone'                           =>  'string'
    ];

    if ($Capitalized) {
        $ReturnFields = [];
        array_walk($Fields, function(&$Value, &$Key) use(&$ReturnFields) {
            $Key = to_camel_case($Key, true);
            $ReturnFields[$Key] = $Value;
        });
    } else {
        $ReturnFields = $Fields;
    }

    return $ReturnFields;
}

function get_item_model($Capitalized = false)
{
    $Fields = [
        'pk'                               => 'string',
        'id'                               => 'string',
        /*
         * A number describing what type of media this is. Should be compared
         * against the `Item::PHOTO`, `Item::VIDEO` and `Item::ALBUM` constants!
         */
        //'media_type'                       => 'int',
        'code'                             => 'string',
        //'visibility'                       => '',
        /*
         * The Unix timestamp (UTC) of when the media was UPLOADED by the user.
         * It is NOT when the media was "taken". It's the upload time.
         */
        'taken_at'                         => 'string',
        'device_timestamp'                 => 'string',
        //'client_cache_key'                 => 'string',
        //'filter_type'                      => 'int',
        //'attribution'                      => 'Attribution',
        //'image_versions2'                  => 'Image_Versions2',
        //'video_versions'                   => 'VideoVersions[]',
        //'original_width'                   => 'int',
        //'original_height'                  => 'int',
        /*
         * This is actually a float in the reply, but is always `.0`, so we cast
         * it to an int instead to make the number easier to manage.
         */
        //'view_count'                       => 'int',
        //'viewer_count'                     => 'int',
        //'organic_tracking_token'           => 'string',
        //'comment_count'                    => 'int',
        //'has_more_comments'                => 'bool',
        //'max_num_visible_preview_comments' => 'int',
        /*
         * Preview of comments via feed replies.
         *
         * If "has_more_comments" is FALSE, then this has ALL of the comments.
         * Otherwise, you'll need to get all comments by querying the media.
         */
        //'preview_comments'                 => 'Comment[]',
        /*
         * Comments for the item.
         *
         * TODO: As of mid-2017, this field seems to no longer be used for
         * timeline feed items? They now use "preview_comments" instead. But we
         * won't delete it, since some other feed MAY use this property for ITS
         * Item object.
         */
        //'comments'                                 => 'Comment[]',
        //'comments_disabled'                        => '',
        //'reel_mentions'                            => 'ReelMention[]',
        //'story_cta'                                => 'StoryCta[]',
        //'caption_position'                         => 'float',
        //'expiring_at'                              => '', // TODO, INVESTIGATE: sometimes int, sometimes float
        //'is_reel_media'                            => 'bool',
        //'next_max_id'                              => 'string',
        //'carousel_media'                           => 'CarouselMedia[]',
        //'carousel_media_type'                      => '',
        //'caption'                                  => 'Caption',
        //'caption_is_edited'                        => 'bool',
        //'photo_of_you'                             => 'bool',
        //'has_audio'                                => 'bool',
        //'video_duration'                           => 'float',
        //'user'                                     => 'User',
        //'likers'                                   => 'User[]',
        //'like_count'                               => 'int',
        //'preview'                                  => 'string',
        //'has_liked'                                => 'bool',
        //'explore_context'                          => 'string',
        //'explore_source_token'                     => 'string',
        //'explore_hide_comments'                    => 'bool',
        //'explore'                                  => 'Explore',
        //'impression_token'                         => 'string',
        //'usertags'                                 => 'Usertag',
        //'media'                                    => 'Media',
        //'stories'                                  => 'Stories',
        //'top_likers'                               => 'string[]',
        //'suggested_users'                          => 'SuggestedUsers',
        //'is_new_suggestion'                        => 'bool',
        //'comment_likes_enabled'                    => 'bool',
        //'can_viewer_save'                          => 'bool',
        //'has_viewer_saved'                         => 'bool',
        //'location'                                 => 'Location',
        //'lat'                                      => 'float',
        //'lng'                                      => 'float',
        //'story_locations'                          => 'StoryLocation[]',
        //'channel'                                  => 'Channel',
        //'gating'                                   => 'Gating',
        //'story_hashtags'                           => 'StoryHashtag[]',
        //'is_dash_eligible'                         => 'int',
        //'video_dash_manifest'                      => 'string',
        //'number_of_qualities'                      => 'int',
        //'injected'                                 => 'Injected',
        //'placeholder'                              => 'Placeholder',
        //'algorithm'                                => 'string',
        //'social_context'                           => 'string',
        //'icon'                                     => '',
        //'media_ids'                                => 'string[]',
        //'media_id'                                 => 'string',
        //'thumbnail_urls'                           => '',
        //'large_urls'                               => '',
        //'media_infos'                              => '',
        //'value'                                    => 'float',
        //'collapse_comments'                        => 'bool',
        //'link'                                     => 'string',
        //'link_text'                                => 'string',
        //'link_hint_text'                           => 'string',
        //'iTunesItem'                               => '',
        //'ad_header_style'                          => 'int',
        //'ad_metadata'                              => 'AdMetadata[]',
        //'ad_action'                                => 'string',
        //'ad_link_type'                             => 'int',
        //'dr_ad_type'                               => 'int',
        //'android_links'                            => 'AndroidLinks[]',
        //'ios_links'                                => 'IOSLinks[]',
        //'force_overlay'                            => 'bool',
        //'hide_nux_text'                            => 'bool',
        //'overlay_text'                             => 'string',
        //'overlay_title'                            => 'string',
        //'overlay_subtitle'                         => 'string',
        //'fb_page_url'                              => 'string',
        //'playback_duration_secs'                   => '',
        //'url_expire_at_secs'                       => '',
        //'is_sidecar_child'                         => '',
        //'comment_threading_enabled'                => 'bool',
        //'cover_media'                              => 'CoverMedia',
        //'saved_collection_ids'                     => 'string[]',
        //'boosted_status'                           => '',
        //'boost_unavailable_reason'                 => '',
        //'viewers'                                  => 'User[]',
        //'viewer_cursor'                            => '',
        //'total_viewer_count'                       => 'int',
        //'multi_author_reel_names'                  => '',
        //'reel_share'                               => 'ReelShare',
        //'story_polls'                              => '',
        //'organic_post_id'                          => 'string',
        //'sponsor_tags'                             => 'User[]',
        //'story_poll_voter_infos'                   => '',
        //'imported_taken_at'                        => '',
        //'lead_gen_form_id'                         => 'string',
        //'ad_id'                                    => 'string',
        //'actor_fbid'                               => 'string',
        //'is_ad4ad'                                 => '',
        //'commenting_disabled_for_viewer'           => '',
        //'story_events'                             => '',
        //'story_feed_media'                         => '',
        //'can_reshare'                              => 'bool',
        //'can_viewer_reshare'                       => 'bool',
        //'is_seen'                                  => '', // TODO: Not sure what type... is always NULL...
        //'creative_config'                          => '', // TODO: Not sure what type... is always NULL...
        //'story_sliders'                            => '', // TODO: Not sure what type... is always []...
        //'story_sound_on'                           => '', // TODO: Not sure what type... is always []...
        //'supports_reel_reactions'                  => 'bool',
        //'inventory_source'                         => 'string',
        //'is_eof'                                   => 'bool',
        //'top_followers'                            => 'string[]',
        //'top_followers_count'                      => 'int',
        //'story_is_saved_to_archive'                => 'bool',
        //'timezone_offset'                          => 'int',
        //'product_tags'                             => 'ProductTags',
        //'inline_composer_display_condition'        => 'string',
        //'highlight_reel_ids'                       => 'string[]',
        //'total_screenshot_count'                   => 'int',
        /*
         * HTML color string such as "#812A2A".
         */
        //'dominant_color'                   => 'string',
    ];

    if ($Capitalized) {
        $ReturnFields = [];
        array_walk($Fields, function(&$Value, &$Key) use(&$ReturnFields) {
            $Key = to_camel_case($Key, true);
            $ReturnFields[$Key] = $Value;
        });
    } else {
        $ReturnFields = $Fields;
    }

    return $ReturnFields;
}

function get_comment_model($Capitalized = false, $Combined = false)
{
    $Fields = [
        //'status'                            => 'string',
        'user_id'                           => 'string',
        /*
         * Unix timestamp (UTC) of when the comment was posted.
         * Yes, this is the UTC timestamp even though it's not named "utc"!
         */
        'created_at'                        => 'string',
        /*
         * WARNING: DO NOT USE THIS VALUE! It is NOT a real UTC timestamp.
         * Instagram has messed up their values of "created_at" vs "created_at_utc".
         * In `getComments()`, both have identical values. In `getCommentReplies()`,
         * both are identical too. But in the `getComments()` "reply previews",
         * their "created_at_utc" values are completely wrong (always +8 hours into
         * the future, beyond the real UTC time). So just ignore this bad value!
         * The real app only reads "created_at" for showing comment timestamps!
         */
        'created_at_utc'                    => 'string',
        //'bit_flags'                         => 'int',
        //'user'                              => 'User',
        'pk'                                => 'string',
        'media_id'                          => 'string',
        'text'                              => 'string',
        //'content_type'                      => 'string',
        /*
         * A number describing what type of comment this is. Should be compared
         * against the `Comment::PARENT` and `Comment::CHILD` constants. All
         * replies are of type `CHILD`, and all parents are of type `PARENT`.
         */
        //'type'                              => 'int',
        //'comment_like_count'                => 'int',
        //'has_liked_comment'                 => 'bool',
        //'has_translation'                   => 'bool',
        //'did_report_as_spam'                => 'bool',
        /*
         * If this is a child in a thread, this is the ID of its parent thread.
         */
        //'parent_comment_id'                 => 'string',
        /*
         * Number of child comments in this comment thread.
         */
        //'child_comment_count'               => 'int',
        /*
         * Previews of some of the child comments. Compare it to the child
         * comment count. If there are more, you must request the comment thread.
         */
        //'preview_child_comments'            => 'Comment[]',
        /*
         * Previews of users in very long comment threads.
         */
        //'other_preview_users'               => 'User[]',
        //'inline_composer_display_condition' => 'string',
        /*
         * When "has_more_tail_child_comments" is true, you can use the value
         * in "next_max_child_cursor" as "max_id" parameter to load up to
         * "num_tail_child_comments" older child-comments.
         */
        //'has_more_tail_child_comments'      => 'bool',
        //'next_max_child_cursor'             => 'string',
        //'num_tail_child_comments'           => 'int',
        /*
         * When "has_more_head_child_comments" is true, you can use the value
         * in "next_min_child_cursor" as "min_id" parameter to load up to
         * "num_head_child_comments" newer child-comments.
         */
        //'has_more_head_child_comments'      => 'bool',
        //'next_min_child_cursor'             => 'string',
        //'num_head_child_comments'           => 'int',
    ];

    if ($Capitalized) {
        $ReturnFields = [];
        array_walk($Fields, function(&$Value, &$Key) use(&$ReturnFields) {
            $Key = to_camel_case($Key, true);
            $ReturnFields[$Key] = $Value;
        });

        if ($Combined) {
            $ProfileAdditionalFields = get_user_model(true);
            $ReturnFields = array_merge($ReturnFields, $ProfileAdditionalFields);
        }
    } else {
        $ReturnFields = $Fields;
    }

    return $ReturnFields;
}
function to_camel_case($str, $capitalise_first_char = false)
{
    if($capitalise_first_char) {
        $str[0] = strtoupper($str[0]);
    }
    return preg_replace_callback(
        '/_([a-z])/',
        function($c) {
            return strtoupper($c[1]);
        },
        $str
    );
}