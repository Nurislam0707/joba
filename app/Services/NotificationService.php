<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;

class NotificationService
{
    public static function create($userId, $title, $message, $type = 'info', $data = [], $relatedUrl = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => $data,
            'related_url' => $relatedUrl
        ]);
    }

    public static function notifyUsers($userIds, $title, $message, $type = 'info', $data = [], $relatedUrl = null)
    {
        foreach ($userIds as $userId) {
            self::create($userId, $title, $message, $type, $data, $relatedUrl);
        }
    }

    public static function notifyGroup($groupId, $title, $message, $type = 'info', $data = [], $relatedUrl = null)
    {
        $group = \App\Models\Group::findOrFail($groupId);
        $userIds = $group->students()->pluck('users.id');
        
        self::notifyUsers($userIds, $title, $message, $type, $data, $relatedUrl);
    }
}