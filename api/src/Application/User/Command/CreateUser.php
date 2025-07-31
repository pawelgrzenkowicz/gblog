<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Domain\Shared\Enum\Role;
use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\Shared\ValueObject\String\NicknameVO;
use App\Domain\Shared\ValueObject\String\PlainPasswordVO;

readonly class CreateUser
{
    public EmailVO $email;

    public NicknameVO $nickname;

    public PlainPasswordVO $plainPassword;

    public Role $role;

    public function __construct(string $email, string $nickname, string $password, Role $role)
    {
        $this->email = new EmailVO($email);
        $this->nickname = new NicknameVO($nickname);
        $this->plainPassword = new PlainPasswordVO($password);
        $this->role = $role;
    }
}
