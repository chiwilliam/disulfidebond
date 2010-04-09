/* COOLjsMenu style + structure file */

var STYLE_0 =
{
    textClass:[ "l0_out", "l0_over" ],
    size:[ 41, 150 ],
    itemoff:[ 0, "+previousItem" ],
    leveloff:[ "+parentItem-5px", 4 ],
    itemFilters:"progid:DXImageTransform.Microsoft.Fade(duration=0.5)"
};

var STYLE_1 = {
    levelFilters:[ "progid:DXImageTransform.Microsoft.Fade(duration=0.5) progid:DXImageTransform.Microsoft.GradientWipe(GradientSize=0.25,wipestyle=1,motion=forward,duration=0.5)", "progid:DXImageTransform.Microsoft.Fade(duration=0.5) progid:DXImageTransform.Microsoft.GradientWipe(GradientSize=0.25,wipestyle=1,motion=reverse,duration=0.5)" ],
    itemFilters:null,
    backgroundClass:[ "l1_bg_other", "l1_bg_other" ],
    borderWidth:[ 1, 0, 1, 0 ],
    color:
    {
        border:"#F2EEEE"
    },
    textClass:[ "l1_out", "l1_over" ],
    size:[ 19, 142 ],
    itemoff:[ "+previousItem", 0 ],
    ifN0:{
        valign:"bottom",
        size:[ 24, 142 ],
        backgroundClass:[ "l1_bg_0", "l1_bg_0" ]
    },
    ifN1:{
        backgroundClass:[ "l1_bg_1", "l1_bg_1" ]
    },
    ifLast:{
        valign:"top",
        size:[ 30, 142 ],
        borders:[ 1, 0, 1, 1 ]
    }
};

var MENU_ITEMS = [
    {style:[ STYLE_0, STYLE_1 ], blankImage:"../images/b.gif" },
    {code:"Home",url:"../index.php"

    },
    {code:"Data",url:"../Instructor/UserMainController.php",
        sub:[
            {},
            {code:"List Data",url:"../Instructor/UserMainController.php"},
            {code:"Edit Profile", url:"../Instructor/StudentProfileController.php"}
        ]
    },
    {code:"Configurations",url:"../Instructor/ListConfigurationController.php",
        sub:[
            {},
            {code:"List Configurations", url:"../Instructor/ListConfigurationController.php"},
            {code:"Add Configuration", url:"../Instructor/AddConfigurationController.php"},
            {code:"Edit Configuration", url:"../Instructor/EditConfigurationController.php?mode=edit"},
            {code:"Delete Configuration", url:"../Instructor/EditConfigurationController.php?mode=delete"},
        ]
    },
    {code:"Projects",url:"../Instructor/ListProjectController.php",
        sub:[
            {},
            {code:"List Projects", url:"../Instructor/ListProjectController.php"},
            {code:"Add Project", url:"../Instructor/AddProjectController.php"},
            {code:"Edit Project", url:"../Instructor/EditProjectController.php?mode=edit"},
            {code:"Delete Project", url:"../Instructor/EditProjectController.php?mode=delete"},
        ]
    },
    {code:"Project Categories",url:"../Instructor/ListProjectController.php",
        sub:[
            {},
            {code:"List Categories", url:"../Instructor/ListCategoryController.php"},
            {code:"Add Category", url:"../Instructor/AddCategoryController.php"},
            {code:"Edit Category", url:"../Instructor/EditCategoryController.php?mode=edit"},
            {code:"Delete Category", url:"../Instructor/EditCategoryController.php?mode=delete"},
        ]
    },
    {code:"Groups",url:"../Instructor/ListOrganizationController.php",
        sub:[
            {},
            {code:"List Groups", url:"../Instructor/ListOrganizationController.php"},
            {code:"Add Group", url:"../Instructor/AddOrganizationController.php"},
            {code:"Edit Group", url:"../Instructor/EditOrganizationController.php?mode=edit"},
            {code:"Delete Group", url:"../Instructor/EditOrganizationController.php?mode=delete"},
        ]
    },
    {code:"Group Comments",url:"../Instructor/ListCommentsController.php",
        sub:[
            {},
            {code:"List Comments", url:"../Instructor/ListCommentsController.php"},
            {code:"Add Comment", url:"../Instructor/AddCommentsController.php"},
            {code:"Edit Comment", url:"../Instructor/EditCommentsController.php?mode=edit"},
            {code:"Delete Comment", url:"../Instructor/EditCommentsController.php?mode=delete"},
        ]
    },
];

var menu1 = new COOLjsMenuPRO("menu1", MENU_ITEMS);
menu1.initTop();
