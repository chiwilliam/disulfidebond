<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
    <!-- #BeginTemplate "master.dwt" -->
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
        <!-- #BeginEditable "doctitle" -->
        <title>Home</title>
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
            <?php 
                $page = "index";
                include "menu.php";
            ?>
            <!-- End Navigation -->
            <!-- Begin Page Content -->
            <div id="page_content">
                <!-- Begin Left Column -->
                <div id="column_l">
                    <!-- #BeginEditable "content" -->
                    <table class="initialcontent" id="index" cellpadding="0" cellspacing="0" summary="" width="95%">
                        <tr>
                            <td>
                                <p></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="justified">
                                <p>
                                    A <b>disulfide bond (S-S)</b>, also called SS-bond or disulfide bridge, is a single covalent bond formed
                                    from the oxidation of sulfhydryl groups. Disulfide bonds play an important role in understanding protein
                                    folding, evolution, and structural properties. Consequently, determining the disulfide bonding pattern 
                                    in a protein is a crucial problem in contemporary proteomics and structural bioinformatics.
                                </p>
                                <p>
                                    At the state of the art, various methodological frameworks have been proposed for identification of disulfide bonds.
                                    These include mass spectrometry-based methods, sequence-based predictive approaches, as well as techniques like
                                    crystallography and NMR. Each of these frameworks has its advantages and disadvantages in terms of applicability,
                                    throughput, and accuracy. While MS-based methods are highly accurate and increasingly being used, they too have
                                    limitations. Thus, no single method is guaranteed to work under all conditions. Furthermore, the results from different
                                    methods may concur or conflict in parts. <b>MS2DB++</b> is designed to address these challenges.
                                </p>                                
                            </td>
                            <td class="imageatright">
                                <!--<img alt="" height="300" src="./images/ms2dbp%20picture.jpg" width="464" />-->
                                <img alt="MS2DB++" height="300" src="./images/summary.png" width="464" />
                            </td>
                        </tr>
                        <!-- For MS2DB++ -->
                        <tr>
                            <td colspan="2" class="justified">
                                <b>MS2DB++</b> is a web application for determining the disulfide connectivity in proteins using an information-fusion
                                approach based on Dempster-Shafer theory (DST). The software provides different methodological frameworks for determining
                                S-S bonds and combines the results automatically and rigorously using DST. This fundamentally novel approach allows <b>MS2DB++</b> 
                                to achieve high sensitivity, specificity and accuracy. It not only outperforms the constituent methods, but also outperforms other 
                                software in the area, such as MassMatrix, MS2Assign, DISULFIND, and PreCys. <b>MS2DB++</b> also provides an easy to use interface, which
                                breaks down the disulfide bond determination process into clear, simple steps.
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="justified">
                                <p>
                                    The constituent S-S bond determination frameworks encoded as part of <b>MS2DB++</b> include:
                                    <ul>
                                        <li>An earlier MS-based method developed by us called <a target="_blank" href="http://haddock2.sfsu.edu/~ms2db/disulfidebond/">MS2DB+</a>.
                                            <a target="_blank" href="http://haddock2.sfsu.edu/~ms2db/disulfidebond/">MS2DB+</a> identifies,
                                            in polynomial time, the disulfide linkages in proteins using tandem mass spectrometry data.
                                            It uses an efficient approximation algorithm which allows the consideration of multiple ion
                                            types in the analysis of MS/MS data (up to 12 different ion types).
                                        </li>
                                        <li>
                                            A sequence-based predictor using a Support Vector Machine (SVM) classifier.
                                        </li>
                                        <li>
                                            A cysteines separation profiles-based (CSP) search method. This pattern-wise approach seeks to
                                            match the disulfide connectivity pattern of a protein against a database of CSPs in order to find
                                            the most resemble pattern. Once the best match is found (lowest divergence between two CSPs), the
                                            S-S connectivity of the protein is inferred based on the disulfide bonds previously annotated for
                                            the matched CSP.
                                        </li>
                                    </ul>
                                </p>                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="justified">
                                <b>MS2DB++</b> also allows users to integrate results from up to two other (arbitrary) external methods. 
                                Lastly, <b>MS2DB++</b> allows users to enter tandem mass spectrometry data in many different formats (i.e. mzXML,
                                mzML, mzData or Sequest DTA files). The protein sequence information is entered in the well-established
                                FASTA format. <b>MS2DB++</b> supports multiple methods of information fusion based on DST. The S-S connectivity
                                determined using each of these methods is presented to the user in a graphical easy-to-read format. The
                                results are also made available in TXT and XML formats. A through description of each combination rule
                                is presented in the
                                <a target="_blank" href="help.php">help</a> section. The most up-to-date source code is available
                                <a target="_blank" href="http://code.google.com/p/disulfidebond/source/checkout">here</a>.
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="centered">
                                <!-- Youtube tutorial video -->
                                <p>
                                    
                                </p>
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