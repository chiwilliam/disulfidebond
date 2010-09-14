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
            <?php include "menu.php" ?>
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
                                    A <b>disulfide bond</b>, also called SS-bond or disulfide bridge, is a single covalent bond formed
                                    from the oxidation of sulfhydryl groups. Disulfide bonds play an important role in understanding protein
                                    folding, evolution, and structural properties.
                                </p>
                                <p>
                                    <b>Mass Spectrometry</b> is a powerful analytical technique used for identification of unknown compounds,
                                    quantification of known compounds, and to elucidate the structure and chemical properties of molecules.
                                    It has become the standard high throughput method for protein identification, and more recently,
                                    for protein quantification.
                                </p>
                                <p>
                                    Determining the disulfide bonding pattern in a protein is one of the critical stepping
                                    stones towards obtaining a mechanistic understanding of its structure and function.
                                    Consequently, this problem is a crucial one in contemporary proteomics and structural
                                    bioinformatics.
                                </p>
                            </td>
                            <td class="imageatright">
                                <img alt="" height="300" src="./images/ms2dbp%20picture.jpg" width="464" />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="justified">
                                <i>Our research group has been developing a web application that addresses these problems and
                                forms the basis of an end-to-end system that requires minimal expert intervention and
                                yet can determine complex disulfide bonding topologies with high efficacy.</i>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="justified">
                                <p>
                                Our methodology uses an approximation algorithm and data driven strategies to
				efficiently address the search and matching problem and find the best disulfide-linked
				structural configuration that can match a given spectra.
				</p>
                                <p>
                                    If you are not familiar with <b><span style="color:blue;">MS2DB+</span></b>, check the demo video
                                    below to get started. <i>(best video quality: 720p HD and full screen)<i/>
				</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="centered">
                                <!-- Youtube tutorial vide -->
                                <p>
                                    <object width="425" height="344"><param name="movie" value="http://www.youtube.com/v/gu9LOpTWCOY?hl=en&fs=1&hd=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/gu9LOpTWCOY?hl=en&fs=1&hd=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="425" height="344"></embed></object>
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