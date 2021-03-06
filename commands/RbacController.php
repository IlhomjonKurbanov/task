<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\components\helpers\Console;
use app\components\Rbac;

/**
 * Class RbacController
 * @package app\commands
 */
class RbacController extends Controller
{
    public $color = true;

    /**
     * Generate roles and permissions
     *
     * @throws \yii\base\Exception
     */
    public function actionInit()
    {
        $auth = Yii::$app->getAuthManager();
        $auth->removeAll();

        // Разрешение просмотр пользователей
        $viewUser = $auth->createPermission(Rbac::PERMISSION_VIEW_USER);
        $viewUser->description = Rbac::PERMISSION_DESCRIPTION_VIEW_USER;
        $auth->add($viewUser);

        // Разрешение изменение пользователя
        $updateUser = $auth->createPermission(Rbac::PERMISSION_UPDATE_USER);
        $updateUser->description = Rbac::PERMISSION_DESCRIPTION_UPDATE_USER;
        $auth->add($updateUser);

        // Разрешение удаление пользователя
        $deleteUser = $auth->createPermission(Rbac::PERMISSION_DELETE_USER);
        $deleteUser->description = Rbac::PERMISSION_DESCRIPTION_DELETE_USER;
        $auth->add($deleteUser);

        // Разрешение Доступ к таблицам
        $accessTable = $auth->createPermission(Rbac::PERMISSION_ACCESS_TABLE);
        $accessTable->description = Rbac::PERMISSION_DESCRIPTION_ACCESS_TABLE;
        $auth->add($accessTable);

        // Разрешение Просмотр таблиц
        $viewTable = $auth->createPermission(Rbac::PERMISSION_VIEW_TABLE);
        $viewTable->description = Rbac::PERMISSION_DESCRIPTION_VIEW_TABLE;
        $auth->add($viewTable);

        // Разрешение Редактирование таблиц
        $editTable = $auth->createPermission(Rbac::PERMISSION_EDIT_TABLE);
        $editTable->description = Rbac::PERMISSION_DESCRIPTION_EDIT_TABLE;
        $auth->add($editTable);

        // Роль Пользователь
        $user = $auth->createRole(Rbac::ROLE_USER);
        $user->description = Rbac::ROLE_DESCRIPTION_USER;
        $auth->add($user);

        // Роль Админ
        $admin = $auth->createRole(Rbac::ROLE_ADMIN);
        $admin->description = Rbac::ROLE_DESCRIPTION_ADMIN;
        $auth->add($admin);

        // Разрешения для Пользователя
        $auth->addChild($user, $accessTable);
        $auth->addChild($user, $viewTable);

        // Разрешения для админа
        $auth->addChild($admin, $viewUser);
        $auth->addChild($admin, $updateUser);
        $auth->addChild($admin, $deleteUser);
        $auth->addChild($admin, $accessTable);
        $auth->addChild($admin, $viewTable);
        $auth->addChild($admin, $editTable);

        $this->stdout(Console::convertEncoding(Yii::t('app', 'Done!')), Console::FG_GREEN, Console::BOLD);
    }
}
