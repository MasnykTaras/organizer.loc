<?php
namespace app\models;

use yii\rbac\Rule;
use app\models\User;
/**
 * Checks if authorID matches user passed via params
 */
class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
       
        if(isset($params['author_id']) && $params['author_id'] == $user || $user == User::WEBMASTER){
            return true;
       
        }else{
            return false;
        }
      
    }
}