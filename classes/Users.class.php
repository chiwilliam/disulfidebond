<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usersclass
 *
 * @author William
 */
class Usersclass {
    public function getAdvancedUserHTML($IMthreshold='1.0', $TMLthreshold='2.0', $ScreeningThreshold='2.0', $IntensityLimit='0.03', $CMthreshold='1.0'){
        
        return '<table class="advancedusers">
                <tr class="advancedusers">
                    <td class="advancedusersleft">Initial Match Threshold:</td>
                    <td class="advancedusersright">
                        <input type="text" id="IMthreshold" name="IMthreshold" size="5" value="'.$IMthreshold.'"></input>
                        * (default: +-1.0)
                    </td>
                </tr>
                <tr class="advancedusers">
                    <td class="advancedusersleft">MS/MS Formation Threshold:</td>
                    <td class="advancedusersright">
                        <input type="text" id="TMLthreshold" name="TMLthreshold" size="5" value="'.$TMLthreshold.'"></input>
                        * expand m/z values according to precursor charge state (default: 2.0)
                    </td>
                </tr>
                <tr class="advancedusers">
                    <td class="advancedusersleft">MS/MS Screening Threshold:</td>
                    <td class="advancedusersright">
                        <input type="text" id="ScreeningThreshold" name="ScreeningThreshold" size="5" value="'.$ScreeningThreshold.'"></input>
                        * selecting a median value for similiar m/z values (default: 2.0)
                    </td>
                </tr>
                <tr class="advancedusers">
                    <td class="advancedusersleft">MS/MS Intensity Limit:</td>
                    <td class="advancedusersright">
                        <input type="text" id="IntensityLimit" name="IntensityLimit" size="5" value="'.$IntensityLimit.'"></input>
                        * lowest m/z intensity accepted (default: 0.03 or 3%)
                    </td>
                </tr>
                <tr class="advancedusers">
                    <td class="advancedusersleft">Confirmed Match Threshold:</td>
                    <td class="advancedusersright">
                        <input type="text" id="CMthreshold" name="CMthreshold" size="5" value="'.$CMthreshold.'"></input>
                        * (default: +-1.0)
                    </td>
                </tr>
                <tr><td colspan="2"><p></p></td></tr>
              </table>';
    }
}
?>
