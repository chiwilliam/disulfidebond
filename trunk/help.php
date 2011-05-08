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
                                        <a href="#Introduction">Introduction to Combination Strategies</a>
                                    </li>
                                    <li class="spacing">
                                        <a href="#Strategy1">Combination Strategy 1</a>
                                    </li>
                                    <li class="spacing">
                                        <a href="#Strategy2">Combination Strategy 2</a>
                                    </li>
                                    <li class="spacing">
                                        <a href="#Strategy3">Combination Strategy 3</a>
                                    </li>
                                    <li class="spacing">
                                        <a href="#Strategy4">Combination Strategy 4</a>
                                    </li>
                                </ol>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h4><a name="Introduction"></a>Introduction to Combination Strategies</h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="justified">
                                <p>
                                    Each disulfide bond determination method contributes with some evidence (score)
                                    towards the final decision about the existence of a disulfide (<i>S-S</i>) bond between a
                                    specific pair of cysteines.
                                    Therefore, coherent combination strategies are required to optimally combine the
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
                                    combination strategies were developed. It is important to note that there is not a 
                                    correct or incorrect combination strategy. Each strategy has its own supporting theory
                                    behind it and may be the optimal solution for a specific set proteins being analyzed
                                    by a specific set of methods.
                                </p>
                                <p>
                                    Overall, MS2DB++ allows users to analyze the same data from different perspectives in
                                    order to obtain the best results. In the following, the different combination strategies 
                                    developed are listed and briefly explained.
                                </p>
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <h4><a name="Strategy1"></a>Combination Strategy 1</h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="justified">
                                According to the combination strategy 1 and considering only two disulfide bond determination
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
                                    The formula used to combine disulfide bonds scores according to strategy 1 is presented below. 
                                    This combination formula is commutative and associative; thus, other disulfide bond determination
                                    methods (and their scores) can be easily added.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="centered">
                                <img alt="Combination Strategy 1" src="images/strategy1.png" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <h4><a name="Strategy2"></a>Combination Strategy 2</h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="justified">
                                According to the combination strategy 2 and considering only two disulfide bond determination
                                methods (for simplicity), the score of a disulfide bond pattern <i>A</i> is:
                                <ul>
                                    <li>
                                        the summation of the product of the scores of bonding patterns <i>B</i> and <i>C</i>, respectively 
                                        obtained by disulfide bond determination methods <i>m<sub>1</sub></i> and <i>m<sub>2</sub></i>, when
                                        the intersection between <i>B</i> and <i>C</i> equals to <i>A</i>.
                                    </li>
                                </ul>
                                <p>
                                    The formula used to combine disulfide bonds scores according to strategy 2 is presented below. 
                                    This combination formula is also commutative and associative; thus, other disulfide bond determination
                                    methods (and their scores) can be easily added.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="centered">
                                <img alt="Combination Strategy 2" src="images/strategy2.png" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <h4><a name="Strategy3"></a>Combination Strategy 3</h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="justified">
                                According to the combination strategy 3 and considering only two disulfide bond determination
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
                                        1 plus the logarithm (base 10) of 1 divided by  
                                        the summation of the product of the scores of bonding patterns <i>B</i> and <i>C</i>, respectively 
                                        obtained by disulfide bond determination methods <i>m<sub>1</sub></i> and <i>m<sub>2</sub></i>, when
                                        the intersection between <i>B</i> and <i>C</i> is not an empty set.
                                    </li>
                                </ul>
                                <p>
                                    The formula used to combine disulfide bonds scores according to strategy 1 is presented below. 
                                    This combination formula is commutative and associative; thus, other disulfide bond determination
                                    methods (and their scores) can be easily added.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="centered">
                                <img alt="Combination Strategy 3" src="images/strategy3.png" />
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <h4><a name="Strategy4"></a>Combination Strategy 4</h4>
                            </td>
                        </tr>
                        <tr>
                            <td class="justified">
                                This combination strategy allows users to weight the scores obtained by
                                each disulfide bond determination method differently. This strategy is specially powerful when the 
                                bonding patterns found are conflicting or if a particular method is known to perform poorly
                                due to a specific motif <i>(i.e.: poor fragmentation in tandem MS/MS analysis,
                                or when a method is known to perform poorly due to a specific amino acid sequence or bonding
                                arrangement)</i>.
                                <p>
                                    While using this strategy, an expert user may assign confidence (reliability) values to the 
                                    bonding scores obtained by the different methods used. These confidence values are then 
                                    multiplied by their respective bonding pattern score.
                                    By default, MS2DB++ assigns maximum confidence (<i>alfa = 1</i>) to all scores.
                                </p>
                                <p>
                                    In this strategy, the score of a bonding pattern <i>A</i> is calculated as the average score of 
                                    all bonding scores <i>A</i> obtained by the different disulfide bond determination methods, 
                                    multiplied by their respective confidence factor <i>alfa</i>. The formula is presented below.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="centered">
                                <img alt="Combination Strategy 4" src="images/strategy4.png" />
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