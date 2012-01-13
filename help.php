<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <!-- #BeginTemplate "master.dwt" -->
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <!-- #BeginEditable "doctitle" -->
        <title>Help</title>
        <!-- #EndEditable -->
        <link href="styles/style1.css" media="screen" rel="stylesheet" title="CSS" type="text/css" />
        <link href="styles/style.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/wz_jsgraphics.js"></script>
    </head>
    <body>
        <script type="text/javascript" src="js/wz_tooltip.js"></script>
        <!-- Begin Container -->
        <div id="container">
            <!-- Begin Header -->
            <?php include "header.php" ?>
            <!-- End Header -->
            <!-- Begin Navigation -->
            <?php include 'menu.php';?>
            <!-- End Navigation -->
            <!-- Begin Page Content -->
            <div id="page_content">
                <!-- Begin Left Column -->
                <div id="column_l">
                    <!-- #BeginEditable "content" -->
                    <table class="content" id="publications" cellpadding="0" cellspacing="0" summary="" width="80%">
                        <tr>
                            <td>
                                <p></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="list">
                                <ol>
                                    <li class="spacing">
                                        <a href="#Usage">MS2DB++ Usage</a>
                                    </li>
                                    <li class="spacing">
                                        <a href="#Introduction">Introduction to Combination Rules</a>
                                    </li>
                                    <li class="spacing">
                                        <a href="#Strategy1">Combination Rule 1 (Dempster rule)</a>
                                    </li>
                                    <li class="spacing">
                                        <a href="#Strategy2">Combination Rule 2 (Campos-Cavalcante rule)</a>
                                    </li>
                                    <li class="spacing">
                                        <a href="#Strategy3">Combination Rule 3 (Yager rule)</a>
                                    </li>
                                    <li class="spacing">
                                        <a href="#Strategy4">Combination Rule 4 (Shafer rule)</a>
                                    </li>
                                </ol>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h4><a name="Usage"></a>MS2DB++ Usage</h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="justified">
                                <p>
                                    The disulfide bond determination process, available under the
                                    section <i>Find Disulfide Connectivity</i>, is divided into four
                                    separate steps:
                                    <ol>
                                        <li>
                                            Method Selection and Data Entry
                                        </li>
                                        <li>
                                            Reliability Assignment
                                        </li>
                                        <li>
                                            Combination Strategies
                                        </li>
                                        <li>
                                            Global Connectivity
                                        </li>
                                    </ol>
                                </p>
                                <p>
                                    <b>1. Method Selection and Data Entry</b><br></br>
                                    In this initial stage, the user can:
                                    <ul>
                                        <li>select the different S-S bond determination frameworks available</li>
                                        <li>enter the protein's FASTA sequence</li>
                                        <li>specify a region where S-S bonds are not expected to occur <i>(optional)</i></li>
                                        <li>if the MS2DB+ framework is selected, the user will be able to upload the MS/MS files,
                                            choose the protease used during digestion, choose the number of
                                            missing cleavage sites, and optionally set the Initial match threshold</li>
                                        <li>if external frameworks are selected, the user will be able to enter the S-S connectivity information</li>
                                    </ul>
                                    Once all the data has been entered, the NEXT buttons should be clicked to move to the next step.
                                </p>
                                <p>
                                    <b>2. Reliability Assignment</b><br></br>
                                    In this step, the putative bonds determined by each framework selected are listed. Reliability scores
                                    are provided by each disulfide bond identified. Initially, all reliability scores are set to 1.0
                                    (maximum value). Optionally, the user is able to tweak (decrease) these scores based on his/her experience.
                                    Some of the facts to consider while decreasing the reliability scores include:
                                    <ul>
                                        <li>technical knowledge of the protein sequence/structure</li>
                                        <li>disulfide bond determination framework</li>
                                        <li>analysis of the MS/MS data involved in the bond identification</li>
                                    </ul>
                                    Links to the MS/MS file(s) involved in the disulfide linkage identified by the MS2DB+ framework are provided.
                                    The MS/MS files can be accessed by clicking on the corresponding disulfide bond.
                                    <br></br>
                                    The next step (available when the user clicks on NEXT) is to select the combination rules based on the
                                    Dempster-Shafer theory (DST).
                                </p>
                                <p>
                                    <b>3. Combination Strategies</b><br></br>
                                    In this step, the user can choose from different combination rules to determine the global disulfide
                                    connectivity pattern. Each combination rule has its advantages, thus aiding in the user analysis and
                                    improving the quality of the results. At least one combination rule is required. The user may want to
                                    choose any or all of them. Please check the subsequent <a href="#Introduction">sections</a> in this 
                                    page for a more detailed description of each combination rule.
                                </p>
                                <p>
                                    <b>4. Global Connectivity</b><br></br>
                                    In this final stage, the global (consistent) disulfide connectivity, obtained using each combination
                                    rule selected in the previous step, are presented in both graphical and text formats. A confidence
                                    score is also assigned to each disulfide bond found.
                                    <br></br>
                                    All results displayed are available for downloads in TXT and XML formats. The intermediary scores
                                    calculated by the different frameworks and used during the information fusion are also available for
                                    downloads in XML format at the bottom of the page.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h4><a name="Introduction"></a>Introduction to Combination Rules</h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="justified">
                                <p>
                                    Each disulfide bond determination method contributes with some evidence (score)
                                    towards the final decision about the existence of a disulfide (<i>S-S</i>) bond between a
                                    specific pair of cysteines.
                                    Therefore, coherent combination rules are required to optimally combine the
                                    score values produced by the different disulfide bond connectivity determination
                                    methods.
                                </p>
                                <p>
                                    MS2DB++ provides to the users the ability of use up to five different disulfide linkage
                                    determination methods, including:
                                    <ul>
                                        <li>MS/MS, developed in our MS2DB+ application (based on MS/MS data);</li>
                                        <li>SVM, a predictive technique using a support vector machine classifier;</li>
                                        <li>CSP, a predictive technique based on cysteine separation profiles;</li>
                                        <li>Two custom methods, where users can provide the bonding patterns determined
                                            by other methods;</li>
                                    </ul>
                                </p>
                                <p>
                                    Given the results obtained by the different disulfide determination methods, different
                                    combination rules were developed. It is important to note that there is not a 
                                    correct or incorrect combination rule. Each rule has its own supporting theory
                                    behind it and may be the optimal solution for a specific set proteins being analyzed
                                    by a specific set of methods.
                                </p>
                                <p>
                                    Overall, MS2DB++ allows users to analyze the same data from different perspectives in
                                    order to obtain the best results. In the following, the different combination rules 
                                    developed are listed and briefly explained.
                                </p>
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <h4><a name="Strategy1"></a>Combination Rule 1 (Dempster rule)</h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="justified">
                                According to the combination rule 1 and considering only two disulfide bond determination
                                methods (for simplicity), the score of a disulfide bond pattern <i>A</i> is:
                                <ul>
                                    <li>
                                        the summation of the product of the scores of bonding patterns <i>B</i> and <i>C</i>, respectively 
                                        obtained by disulfide bond determination methods <i>m<sub>1</sub></i> and <i>m<sub>2</sub></i>, when
                                        the intersection between <i>B</i> and <i>C</i> equals to <i>A</i> and bonding pattern <i>A</i> is not 
                                        an empty set.
                                    </li>
                                    <li>
                                        divided by
                                    </li>
                                    <li>
                                        the summation of the product of the scores of bonding patterns <i>B</i> and <i>C</i>, respectively 
                                        obtained by disulfide bond determination methods <i>m<sub>1</sub></i> and <i>m<sub>2</sub></i>, when
                                        the intersection between <i>B</i> and <i>C</i> is not an empty set.
                                    </li>
                                </ul>
                                <p>
                                    The formula used to combine disulfide bonds scores according to rule 1 is presented below. 
                                    This combination formula is commutative and associative; thus, other disulfide bond determination
                                    methods (and their scores) can be easily added.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="centered">
                                <img alt="Combination Rule 1" src="images/strategy1.png" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <h4><a name="Strategy2"></a>Combination Rule 2 (Campos-Cavalcante rule)</h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="justified">
                                According to the combination rule 2 and considering only two disulfide bond determination
                                methods (for simplicity), the score of a disulfide bond pattern <i>A</i> is:
                                <ul>
                                    <li>
                                        the summation of the product of the scores of bonding patterns <i>B</i> and <i>C</i>, respectively 
                                        obtained by disulfide bond determination methods <i>m<sub>1</sub></i> and <i>m<sub>2</sub></i>, when
                                        the intersection between <i>B</i> and <i>C</i> equals to <i>A</i>.
                                    </li>
                                </ul>
                                <p>
                                    The formula used to combine disulfide bonds scores according to rule 2 is presented below. 
                                    This combination formula is also commutative and associative; thus, other disulfide bond determination
                                    methods (and their scores) can be easily added.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="centered">
                                <img alt="Combination Rule 2" src="images/strategy2.png" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <h4><a name="Strategy3"></a>Combination Rule 3 (Yager rule)</h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="justified">
                                According to the combination rule 3 and considering only two disulfide bond determination
                                methods (for simplicity), the score of a disulfide bond pattern <i>A</i> is:
                                <ul>
                                    <li>
                                        the summation of the product of the scores of bonding patterns <i>B</i> and <i>C</i>, respectively 
                                        obtained by disulfide bond determination methods <i>m<sub>1</sub></i> and <i>m<sub>2</sub></i>, when
                                        the intersection between <i>B</i> and <i>C</i> equals to <i>A</i> and bonding pattern <i>A</i> is not 
                                        an empty set.
                                    </li>
                                    <li>
                                        multiplied by
                                    </li>
                                    <li>
                                        <i>I</i>, which is 1 divided by the summation of the product of the scores of bonding patterns
                                        <i>B</i> and <i>C</i>, respectively obtained by disulfide bond determination methods
                                        <i>m<sub>1</sub></i> and <i>m<sub>2</sub></i>, when the intersection between <i>B</i> and <i>C</i>
                                        is not an empty set.
                                    </li>
                                    <li>
                                        divided by
                                    </li>
                                    <li>
                                        1 plus the logarithm (base 10) of <i>I</i>.
                                    </li>
                                </ul>
                                <p>
                                    The formula used to combine disulfide bonds scores according to rule 1 is presented below. 
                                    This combination formula is commutative and associative; thus, other disulfide bond determination
                                    methods (and their scores) can be easily added.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="centered">
                                <img alt="Combination Rule 3" src="images/strategy3.png" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <h4><a name="Strategy4"></a>Combination Rule 4 (Shafer rule)</h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="justified">
                                This combination rule allows users to weight the scores obtained by
                                each disulfide bond determination method differently. This rule is specially powerful when the 
                                bonding patterns found are conflicting or if a particular method is known to perform poorly
                                due to a specific motif <i>(i.e.: poor fragmentation in tandem MS/MS analysis,
                                or when a method is known to perform poorly due to a specific amino acid sequence or bonding
                                arrangement)</i>.
                                <p>
                                    While using this rule, an expert user may assign reliability values to the 
                                    bonding scores obtained by the different methods used. These reliability values are then 
                                    multiplied by their respective bonding pattern score.
                                    By default, MS2DB++ assigns maximum reliability (<i>alfa = 1</i>) to all scores.
                                </p>
                                <p>
                                    In this rule, the score of a bonding pattern <i>A</i> is calculated as the average score of 
                                    all bonding scores <i>A</i> obtained by the different disulfide bond determination methods, 
                                    multiplied by their respective confidence factor <i>alfa</i>. The formula is presented below.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="centered">
                                <img alt="Combination Rule 4" src="images/strategy4.png" />
                            </td>
                        </tr>
                        
                    </table>
                    <!-- #EndEditable "content" -->
                </div>
                <!-- End Left Column -->
            </div>
            <!-- End Page Content -->
            <!-- Begin Footer -->
            <?php include "footer.php" ?>
            <!-- End Footer -->
        </div><!-- End Container -->
    </body>
    <!-- #EndTemplate -->
</html>