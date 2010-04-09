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
    {code:"Item 1",
        sub:[
            {},
            {code:"SubItem 1"},
            {code:"SubItem 2"},
            {code:"SubItem 3"},
            {code:"SubItem 4"},
            {code:"SubItem 5"}
        ]
    },
    {code:"Item 2", url:"#",
        sub:[
            {},
            {code:"SubItem 1"},
            {code:"SubItem 2"},
            {code:"SubItem 3"},
            {code:"SubItem 4"},
            {code:"SubItem 5"}
        ]
    },
    {code:"Item 3",
        sub:[
            {},
            {code:"SubItem 1"},
            {code:"SubItem 2"},
            {code:"SubItem 3"},
            {code:"SubItem 4"},
            {code:"SubItem 5"}
        ]
    },
    {code:"Item 4",
        sub:[
            {},
            {code:"SubItem 1"},
            {code:"SubItem 2"},
            {code:"SubItem 3"},
            {code:"SubItem 4"},
            {code:"SubItem 5"}
        ]
    },
];

var menu1 = new COOLjsMenuPRO("menu1", MENU_ITEMS);
menu1.initTop();
