<?php
namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\AuthorRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // "createPost"
        $createTask = $auth->createPermission('createTask');
        $createTask->description = 'Create a task';
        $auth->add($createTask);

        // "updatePost"
        $updateTask = $auth->createPermission('updateTask');
        $updateTask->description = 'Update task';
        $auth->add($updateTask);
        
         // add the rule
        $rule = new AuthorRule();
        $auth->add($rule);

        // add "updateOwnTask" .
        $updateOwnTask = $auth->createPermission('updateOwnTask');
        $updateOwnTask->description = 'Update own task';
        $updateOwnTask->ruleName = $rule->name;
        $auth->add($updateOwnTask);

        // add role "author" add to author action "createTask"
        $author = $auth->createRole('author');
        $author->description = "Author";
        $auth->add($author);
        $auth->addChild($author, $updateOwnTask);
       

        // add role "admin" add to admin action "createPost"
        // add to  all action "author" role
        $admin = $auth->createRole('admin');
        $admin->description = "Admin";
        $auth->add($admin);
        $auth->addChild($admin, $createTask);
        $auth->addChild($admin, $author);
        
        // "updateOwnPost" from "updatePost"
        $auth->addChild($updateOwnTask, $updateTask);

        
        $auth->assign($admin, 1);
        $auth->assign($author, 2);
        $auth->assign($author, 3);
        $auth->assign($author, 4);
        $auth->assign($author, 5);
        
    }
}