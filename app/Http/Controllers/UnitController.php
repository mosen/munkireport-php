<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use munkireport\models\Business_unit;
use munkireport\models\Machine_group;

class UnitController extends Controller
{
    public function __construct()
    {
        if (!Str::contains(config('auth.methods'), 'NOAUTH')) {
            $this->middleware('auth');
        }
    }

    /**
     * Get unit data for current user
     *
     * @author
     **/
    public function get_data()
    {
        $out = array();

        // Initiate session
        $this->authorized();

        if (isset($_SESSION['business_unit'])) {
            // Get data for this unit
            $unit = new Business_unit;
            $out = $unit->all($_SESSION['business_unit']);
        }

        return jsonView($out, 200, false, true);
    }

    /**
     * Get machine group data for current user
     *
     * @author
     **/
    public function get_machine_groups()
    {
        $out = array();

        if (isset($_SESSION['machine_groups'])) {
            // Get data for this unit
            $mg = new Machine_group;
            foreach ($_SESSION['machine_groups'] as $group) {
                if ($mg_data = $mg->all($group)) {
                    $out[] = $mg->all($group);
                } else if ($group != 0 && count($_SESSION['machine_groups']) != 0) // Not in Machine_group table
                {
                    $out[] = array(
                        'name' => 'Group '.$group,
                        'groupid' => $group);
                } else {
                    $out[] = array(
                        'name' => 'Unassigned',
                        'groupid' => $group);
                }
            }
        } else {
            $mg = new Machine_group;
            $out = $mg->all();
        }

        //Apply filter
        $groups = get_filtered_groups();
        foreach ($out as &$group) {
            $group['checked'] = in_array($group['groupid'], $groups);
        }

        usort($out, function($a, $b) {
            return strcasecmp($a['name'], $b['name']);
        });

        return jsonView($out, 200, false, true);
    }
}
