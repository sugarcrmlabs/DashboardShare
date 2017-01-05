<?php

class CustomDashboadShareApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'DashboardShare' => array(
                'reqType' => 'GET',
                'path' => array('getUsersForShare'),
                'pathVars' => array(''),
                'method' => 'getUsers',
                'shortHelp' => 'Retrieves the users grouped by roles and teams',
                'longHelp' => '',
            ),
            'DashboardSave' => array(
                'reqType' => 'POST',
                'path' => array('shareDashboardWithUsers'),
                'pathVars' => array(''),
                'method' => 'shareIt',
                'shortHelp' => 'Shares the given dashboard with the given users',
                'longHelp' => '',
            )
        );
    }

    function getUsers($api, $args)
    {
        $response = array();
        $roleUserSql = "SELECT
            u.first_name,
            u.last_name,
            u.user_name,
            u.id,
            ar.name as role_name
        FROM acl_roles_users acu
        INNER JOIN acl_roles ar ON acu.role_id = ar.id AND ar.deleted = 0
        INNER JOIN users u ON acu.user_id = u.id AND u.deleted = 0
        WHERE acu.deleted = 0
        ORDER BY ar.name";

        $roleUserQuery = $GLOBALS['db']->query($roleUserSql);
        $currentRole = "";
        $roleGroups = array();
        while ($row = $GLOBALS['db']->fetchByAssoc($roleUserQuery)) {
            if ($row['role_name'] != $currentRole && empty($roleGroups[$row['role_name']])) {
                $currentRole = $row['role_name'];
                $roleGroups[$currentRole] = array();
            }

            $roleGroups[$currentRole][] = array(
                'id' => $row['id'],
                'name' => $row['first_name'] . ' ' . $row['last_name']
            );
        }

        $response['roles'] = $roleGroups;

        $teamUserSql = "SELECT
            u.first_name,
            u.last_name,
            u.user_name,
            u.id,
            t.name as team_name
        FROM team_memberships tm
        INNER JOIN teams t ON tm.team_id = t.id AND t.deleted = 0
        INNER JOIN users u ON tm.user_id = u.id AND u.deleted = 0
        WHERE tm.deleted = 0
        ORDER BY t.name";

        $teamUserQuery = $GLOBALS['db']->query($teamUserSql);
        $currentTeam = "";
        $teamGroups = array();
        while ($row = $GLOBALS['db']->fetchByAssoc($teamUserQuery)) {
            if ($row['team_name'] != $currentTeam && empty($roleGroups[$row['team_name']])) {
                $currentTeam = $row['team_name'];
                $teamGroups[$currentTeam] = array();
            }

            $teamGroups[$currentTeam][] = array(
                'id' => $row['id'],
                'name' => $row['first_name'] . ' ' . $row['last_name']
            );
        }

        $response['teams'] = $teamGroups;

        $userSql = "SELECT
            u.first_name,
            u.last_name,
            u.user_name,
            u.id
        FROM users u
        WHERE u.deleted = 0
        ORDER BY u.first_name";

        $userQuery = $GLOBALS['db']->query($userSql);
        $users = array();
        while ($row = $GLOBALS['db']->fetchByAssoc($userQuery)) {
            $users[] = array(
                'id' => $row['id'],
                'name' => $row['first_name'] . ' ' . $row['last_name']
            );
        }

        $response['users'] = $users;
        return $response;
    }

    public function shareIt($api, $args)
    {
        global $sugar_config;


        if (empty($args['user_ids']) || empty($args['dashboard_id'])) {
            throw new SugarApiExceptionMissingParameter();
        }

        $query = new SugarQuery();
        $query->from(BeanFactory::getBean("Dashboards"));
        $query->where()->equals('id',$args['dashboard_id']);

        $dashboard = $query->execute();

        $allow_edit = $args['allow_edit'] ? $args['allow_edit'] : 0;

        if (!empty($dashboard)) {
            $newDashboard = $dashboard[0];

            $metadata = json_decode($newDashboard['metadata'], true);
            $metadata['allow_edit'] = $allow_edit;
            $newDashboard['metadata'] = json_encode($metadata);

            $userIds = $args['user_ids'];
            foreach($userIds as $user_id) {
                $query = new SugarQuery();
                $query->from(BeanFactory::getBean("Dashboards"), array('team_security' => false));
                $query->where()->equals('created_by',$newDashboard['created_by']);
                $query->where()->equals('assigned_user_id',$user_id);
                $query->where()->equals('name',$newDashboard['name']);
                $query->where()->equals('deleted', 0);

                //skip this dashboard if already shared
                if ($query->getOne() !== false) {
                    continue;
                }

                $newDashboard['id'] = create_guid();
                $newDashboard['assigned_user_id'] = $user_id;
                $newDashboard['modified_user_id'] = $user_id;
                $newDashboard['deleted'] = 1;

                $count = 0;
                $fields = '';

                $user = BeanFactory::getBean("Users", $user_id);

                foreach($newDashboard as $col => $val) {
                    if ($count++ != 0) $fields .= ', ';
                    $fields .=  $col . " = " . $GLOBALS['db']->quoted($val);
                }

                $insertQuery = "INSERT INTO dashboards SET " . $fields . ";";

                if ($GLOBALS['db']->query($insertQuery)) {
                    //send notification email
                    $user = BeanFactory::getBean("Users", $user_id);

                    $accept = "<a href='" . $sugar_config['site_url'] . "/index.php?entryPoint=customEntryPoint&dashId=" . $newDashboard['id'] . "' target='_blank'>accept it</a>";

                    $subject = "You have a new dashboard shared with you!";
                    $body = $GLOBALS['current_user']->first_name . " " . $GLOBALS['current_user']->last_name .
                        " has shared his \"" . translate($newDashboard['name']) . "\" with you. Do you wish to " . $accept . " ?";

                    $mailer = MailerFactory::getMailerForUser($GLOBALS['current_user']);
                    $mailer->setSubject($subject);
                    $mailer->setHtmlBody($body);
                    $mailer->addRecipientsTo(new EmailIdentity($user->email1));

                    $mailer->send();
                }
            }
        } else {
            throw new SugarApiExceptionInvalidParameter();
        }
    }
}
