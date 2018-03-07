<?php

use yii\db\Migration;
use backend\models\User;


/**
 * Class m180307_131456_create_rbac_data
 */
class m180307_131456_create_rbac_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // Define permissions

        $viewComplaintsListPermission = $auth->createPermission('viewComplaintsList');
        $auth->add($viewComplaintsListPermission);

        $approvePostPermission = $auth->createPermission('approvePost');
        $auth->add($approvePostPermission);

        $viewPostsListPermission = $auth->createPermission('viewPostsList');
        $auth->add($viewPostsListPermission);

        $viewPostPermission = $auth->createPermission('viewPost');
        $auth->add($viewPostPermission);

        $deletePostPermission = $auth->createPermission('deletePost');
        $auth->add($deletePostPermission);

        $viewUsersListPermission = $auth->createPermission('viewUsersList');
        $auth->add($viewUsersListPermission);

        $viewUserPermission = $auth->createPermission('viewUser');
        $auth->add($viewUserPermission);

        $updateUserPermission = $auth->createPermission('updateUser');
        $auth->add($updateUserPermission);

        $deleteUserPermission = $auth->createPermission('deleteUser');
        $auth->add($deleteUserPermission);



        // Define roles

        $moderatorRole = $auth->createRole('moderator');
        $auth->add($moderatorRole);

        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);



        // Define roles - permissions relations

        $auth->addChild($moderatorRole, $viewComplaintsListPermission);
        $auth->addChild($moderatorRole, $approvePostPermission);
        $auth->addChild($moderatorRole, $viewPostsListPermission);
        $auth->addChild($moderatorRole, $viewPostPermission);
        $auth->addChild($moderatorRole, $deletePostPermission);
        $auth->addChild($moderatorRole, $viewUsersListPermission);
        $auth->addChild($moderatorRole, $viewUserPermission);


        $auth->addChild($adminRole, $moderatorRole);
        $auth->addChild($adminRole, $updateUserPermission);
        $auth->addChild($adminRole, $deleteUserPermission);

        // Create admin user

        $user = new User([
            'email' => 'admin@admin.com',
            'username' => 'Admin',
            'password_hash' => '$2y$13$hCDnhoGdQH7LJlfrOmSqu.BXPjvQZ68BWkQ1sy1VZrDTwtfOyjZve',
        ]);

        $user->generateAuthKey();
        $user->save();

        // Add admin role to user
        $auth->assign($adminRole, $user->getId());

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180307_131456_create_rbac_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180307_131456_create_rbac_data cannot be reverted.\n";

        return false;
    }
    */
}
