<script type="text/javascript">

    function myDrawFunction()
    {
        /*
         * first position: 0,0
         * last position: (30*20=600),(20*#rows)
         * each horizontal change: +-20px
         * each vertical change: +-20px
         *
         * Disulfide Bond between cysteines C1 and C2
         * rowC1 = (int)C1/30
         * rowC2 = (int)C2/30
         * if rowC1 == rowC2
         *      they are in the same row
         *      then if C2 > C1
         *              draw Polyline from C1 to C2
         *                  Xpoints = new Array(x1,x2,x3,x4)
         *                  Ypoints = new Array(x1,x2,x3,x4)
         *                  .drawPolyline(Xpoints, YPoints)
         *           else
         *              draw Polyline from C2 to C1
         *                  Xpoints = new Array(x1,x2,x3,x4)
         *                  Ypoints = new Array(x1,x2,x3,x4)
         *                  .drawPolyline(Xpoints, YPoints)
         * else
         *      they are in different rows
         *      colC1 = C1%30
         *      colC2 = C2%30
         *      if rowC2 > rowC1
         *          if colC1 == colC2
         *              
         *          else
         *              if colC2 > colC1
         *
         *              else
         *      else
         *
         */
        jg_doc.setColor("yellow");
        jg_doc.setStroke(2);
        jg_doc.drawLine(0,0,600,80);
        jg_doc.paint(); // draws, in this case, directly into the document
    }

    var jg_doc = new jsGraphics("graphdiv"); // draw directly into document

    myDrawFunction();

</script>
<table class="graphtable">
    <tr align="center">
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphselectedtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
    </tr>
    <tr align="center">
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphselectedtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
    </tr>
    <tr align="center">
        <td class="graphselectedtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
    </tr>
    <tr align="center">
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphselectedtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
        <td class="graphtd">A
        </td>
    </tr>
</table>