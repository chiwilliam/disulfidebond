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
                                    Methods for determining S-S bonds can be broadly grouped into two categories: 
                                    those that use sequence-level information to predict disulfide bonds, and those based on data 
                                    from mass spectrometry (MS), crystallography or NMR. Of these two classes of methods, 
                                    MS-based approaches are especially interesting due to their high accuracy. Furthermore, 
                                    unlike crystallography or NMR, MS-based disulfide bond determination can be carried out 
                                    with relatively small quantities of the analytes. Predictive methods based on sequence-level 
                                    information are known to perform better than MS-based methods when the MS data provides low
                                    resolution.
                                </p>                                
                            </td>
                            <td class="imageatright">
                                <!--<img alt="" height="300" src="./images/ms2dbp%20picture.jpg" width="464" />-->
                                <img alt="MS2DB++" height="300" src="./images/summary.png" width="464" />
                            </td>
                        </tr>
                        <!-- For MS2DB+
                        <tr>
                            <td colspan="2" class="justified">
                                <b>MS2DB+</b> is an open-source platform-independent web application that efficiently determines 
                                the disulfide linkage in proteins based on mass spectrometry data. 
                                The software can account for multiple ions (a, b, bo, b*, c, x, y, yo, y*, and z) in determining the 
                                disulfide bonds, yet ensuring that the solution is found in polynomial time.
                            </td>
                        </tr>
                        -->
                        <!-- For MS2DB++ -->
                        <tr>
                            <td colspan="2" class="justified">
                                <b>MS2DB++</b> is an open-source platform-independent web application that efficiently determines 
                                the disulfide connectivity in proteins by allowing users to combine a method based on Mass Spectrometry 
                                data with methods based on machine learning techniques. The combination of different methods is fully 
                                controlled by the user, enhancing the user experience and improving the final results.                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="justified">
                                <p>
                                    MS2DB++ uses the framework available in MS2DB+ to determine S-S bonds using Mass Spectrometry data.
                                    While analyzing tandem MS/MS data, the software can account for multiple ions (a, b, bo, b*, c, x, y, yo, 
                                    y*, and z) in determining the disulfide bonds, yet ensuring that the solution is found in polynomial time.
                                    Two other methods based on machine learning techniques to analyze sequence-level information
                                    are also available in MS2DB++. The first is based on a SVM-classifier and the second method is based on 
                                    cysteines separation profiles (CSPs).
                                </p>                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="justified">
                                Lastly, MS2DB++ allows the user to enter the bonding pattern found by custom methods, which can be combined 
                                with the results obtained by the other three methods (MS/MS, SVM, and CSP) to determine a global consistent 
                                disulfide connectivity. The methods' combination can be performed using four different rules, also 
                                fully controlled by the user. The different combination rules/options aim to improve the quality and 
                                accuracy of the results. A through description of each combination rule is presented in the 
                                <a target="_blank" href="help.php">help</a> section.
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="justified">                               
                                <p>
                                    If you are not familiar with MS2DB++, check the demo video
                                    below to get started <i>(best video quality: 720p HD and full screen)</i> or click 
                                        <a target="_blank" href="videos/ms2db++_demo.wmv">here</a>
                                    to download/access the video directly. The most up-to-date source code is available 
                                        <a target="_blank" href="http://code.google.com/p/disulfidebond/source/checkout">here</a>.                                    
				</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="centered">
                                <!-- Youtube tutorial vide -->
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