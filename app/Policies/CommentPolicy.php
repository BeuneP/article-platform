<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    public function delete(User $user, Comment $comment)
    {
        // Разрешить удаление, если пользователь является автором комментария
        // или администратором (если реализовано администраторство)
        return $user->id === $comment->user_id;
    }
}
