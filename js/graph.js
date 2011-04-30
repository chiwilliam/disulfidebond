function myDrawFunction1(C1,C2,Hspacing,Vspacing,totalperrow,color,stroke)
{
    /*
         *first position: 0,0
         *last position: (30*20=600),(20*#rows)
         *each horizontal change: +-Hspacing px
         *each vertical change: +-Vspacing px
         *
         *Disulfide Bond between cysteines C1 and C2
         */

    jg_doc1.setColor(color);
    jg_doc1.setStroke(stroke);

    var rowC1 = parseInt(C1/totalperrow);
    var rowC2 = parseInt(C2/totalperrow);
    var colC1 = C1%30;
    var colC2 = C2%30;
    var correction = 0;

    if (rowC1 == rowC2){
        //they are in the same row
        var Xpoints = new Array((colC1*Hspacing)+(Hspacing-Hspacing/2),(colC1*Hspacing)+(Hspacing-Hspacing/2),
            (colC2*Hspacing)+(Hspacing-Hspacing/2),(colC2*Hspacing)+(Hspacing-Hspacing/2));
        var Ypoints = new Array((rowC1*Vspacing),(rowC1*Vspacing)-(Vspacing/4),
            (rowC2*Vspacing)-(Vspacing/4),(rowC2*Vspacing));
        jg_doc1.drawPolyline(Xpoints, Ypoints);
    }
    else{
        //they are in different rows
        if(rowC2 > rowC1){
            if(colC1 == colC2){
                jg_doc1.drawLine((colC1*Hspacing)+(Hspacing-Hspacing/2),(rowC1*Vspacing)+(Vspacing),
                    (colC2*Hspacing)+(Hspacing-Hspacing/2),(rowC2*Vspacing));
            }
            else{
                if(colC2 > colC1){
                    jg_doc1.drawLine(((colC1*Hspacing)+(Hspacing))-correction,((rowC1*Vspacing)+(Vspacing-Vspacing/4))-correction,
                        (colC2*Hspacing)+correction,((rowC2*Vspacing)+(Vspacing-3*Vspacing/4))+correction);
                }
                else{
                    jg_doc1.drawLine((colC1*Hspacing)+correction,((rowC1*Vspacing)+(Vspacing-Vspacing/4))+correction,
                        ((colC2*Hspacing)+(Hspacing-Hspacing/4))-correction,(rowC2*Vspacing)-correction);
                }
            }
        }
        else{
            if(colC2 == colC1){
                jg_doc1.drawLine((colC2*Hspacing)+(Hspacing-Hspacing/2),(rowC2*Vspacing)+(Vspacing),
                    (colC1*Hspacing)+(Hspacing-Hspacing/2),(rowC1*Vspacing));
            }
            else{
                if(colC1 > colC2){
                    jg_doc1.drawLine(((colC2*Hspacing)+(Hspacing))-correction,((rowC2*Vspacing)+(Vspacing-Vspacing/4))-correction,
                        (colC1*Hspacing)+correction,(rowC1*Vspacing)+correction);
                }
                else{
                    jg_doc1.drawLine((colC2*Hspacing)+correction,((rowC2*Vspacing)+(Vspacing-Vspacing/4))+correction,
                        ((colC1*Hspacing)+(Hspacing-Hspacing/4))-correction,(rowC1*Vspacing)-correction);
                }
            }
        }
    }

    /*
            jg_doc1.drawLine(110,20,110,60);
            jg_doc1.drawLine(120,15,340,25);
            jg_doc1.drawLine(100,15,15,45);
            jg_doc1.drawPolyline(new Array(400+10,400+10,540+10,540+10), new Array(40,40-5,40-5,40));
        */

    jg_doc1.paint(); // draws, in this case, directly into the document
    
}

function myDrawFunction2(C1,C2,Hspacing,Vspacing,totalperrow,color,stroke)
{
    /*
         *first position: 0,0
         *last position: (30*20=600),(20*#rows)
         *each horizontal change: +-Hspacing px
         *each vertical change: +-Vspacing px
         *
         *Disulfide Bond between cysteines C1 and C2
         */

    jg_doc2.setColor(color);
    jg_doc2.setStroke(stroke);

    var rowC1 = parseInt(C1/totalperrow);
    var rowC2 = parseInt(C2/totalperrow);
    var colC1 = C1%30;
    var colC2 = C2%30;
    var correction = 0;

    if (rowC1 == rowC2){
        //they are in the same row
        var Xpoints = new Array((colC1*Hspacing)+(Hspacing-Hspacing/2),(colC1*Hspacing)+(Hspacing-Hspacing/2),
            (colC2*Hspacing)+(Hspacing-Hspacing/2),(colC2*Hspacing)+(Hspacing-Hspacing/2));
        var Ypoints = new Array((rowC1*Vspacing),(rowC1*Vspacing)-(Vspacing/4),
            (rowC2*Vspacing)-(Vspacing/4),(rowC2*Vspacing));
        jg_doc2.drawPolyline(Xpoints, Ypoints);
    }
    else{
        //they are in different rows
        if(rowC2 > rowC1){
            if(colC1 == colC2){
                jg_doc2.drawLine((colC1*Hspacing)+(Hspacing-Hspacing/2),(rowC1*Vspacing)+(Vspacing),
                    (colC2*Hspacing)+(Hspacing-Hspacing/2),(rowC2*Vspacing));
            }
            else{
                if(colC2 > colC1){
                    jg_doc2.drawLine(((colC1*Hspacing)+(Hspacing))-correction,((rowC1*Vspacing)+(Vspacing-Vspacing/4))-correction,
                        (colC2*Hspacing)+correction,((rowC2*Vspacing)+(Vspacing-3*Vspacing/4))+correction);
                }
                else{
                    jg_doc2.drawLine((colC1*Hspacing)+correction,((rowC1*Vspacing)+(Vspacing-Vspacing/4))+correction,
                        ((colC2*Hspacing)+(Hspacing-Hspacing/4))-correction,(rowC2*Vspacing)-correction);
                }
            }
        }
        else{
            if(colC2 == colC1){
                jg_doc2.drawLine((colC2*Hspacing)+(Hspacing-Hspacing/2),(rowC2*Vspacing)+(Vspacing),
                    (colC1*Hspacing)+(Hspacing-Hspacing/2),(rowC1*Vspacing));
            }
            else{
                if(colC1 > colC2){
                    jg_doc2.drawLine(((colC2*Hspacing)+(Hspacing))-correction,((rowC2*Vspacing)+(Vspacing-Vspacing/4))-correction,
                        (colC1*Hspacing)+correction,(rowC1*Vspacing)+correction);
                }
                else{
                    jg_doc2.drawLine((colC2*Hspacing)+correction,((rowC2*Vspacing)+(Vspacing-Vspacing/4))+correction,
                        ((colC1*Hspacing)+(Hspacing-Hspacing/4))-correction,(rowC1*Vspacing)-correction);
                }
            }
        }
    }

    /*
            jg_doc2.drawLine(110,20,110,60);
            jg_doc2.drawLine(120,15,340,25);
            jg_doc2.drawLine(100,15,15,45);
            jg_doc2.drawPolyline(new Array(400+10,400+10,540+10,540+10), new Array(40,40-5,40-5,40));
        */

    jg_doc2.paint(); // draws, in this case, directly into the document
}

function myDrawFunction3(C1,C2,Hspacing,Vspacing,totalperrow,color,stroke)
{
    /*
         *first position: 0,0
         *last position: (30*20=600),(20*#rows)
         *each horizontal change: +-Hspacing px
         *each vertical change: +-Vspacing px
         *
         *Disulfide Bond between cysteines C1 and C2
         */

    jg_doc3.setColor(color);
    jg_doc3.setStroke(stroke);

    var rowC1 = parseInt(C1/totalperrow);
    var rowC2 = parseInt(C2/totalperrow);
    var colC1 = C1%30;
    var colC2 = C2%30;
    var correction = 0;

    if (rowC1 == rowC2){
        //they are in the same row
        var Xpoints = new Array((colC1*Hspacing)+(Hspacing-Hspacing/2),(colC1*Hspacing)+(Hspacing-Hspacing/2),
            (colC2*Hspacing)+(Hspacing-Hspacing/2),(colC2*Hspacing)+(Hspacing-Hspacing/2));
        var Ypoints = new Array((rowC1*Vspacing),(rowC1*Vspacing)-(Vspacing/4),
            (rowC2*Vspacing)-(Vspacing/4),(rowC2*Vspacing));
        jg_doc3.drawPolyline(Xpoints, Ypoints);
    }
    else{
        //they are in different rows
        if(rowC2 > rowC1){
            if(colC1 == colC2){
                jg_doc3.drawLine((colC1*Hspacing)+(Hspacing-Hspacing/2),(rowC1*Vspacing)+(Vspacing),
                    (colC2*Hspacing)+(Hspacing-Hspacing/2),(rowC2*Vspacing));
            }
            else{
                if(colC2 > colC1){
                    jg_doc3.drawLine(((colC1*Hspacing)+(Hspacing))-correction,((rowC1*Vspacing)+(Vspacing-Vspacing/4))-correction,
                        (colC2*Hspacing)+correction,((rowC2*Vspacing)+(Vspacing-3*Vspacing/4))+correction);
                }
                else{
                    jg_doc3.drawLine((colC1*Hspacing)+correction,((rowC1*Vspacing)+(Vspacing-Vspacing/4))+correction,
                        ((colC2*Hspacing)+(Hspacing-Hspacing/4))-correction,(rowC2*Vspacing)-correction);
                }
            }
        }
        else{
            if(colC2 == colC1){
                jg_doc3.drawLine((colC2*Hspacing)+(Hspacing-Hspacing/2),(rowC2*Vspacing)+(Vspacing),
                    (colC1*Hspacing)+(Hspacing-Hspacing/2),(rowC1*Vspacing));
            }
            else{
                if(colC1 > colC2){
                    jg_doc3.drawLine(((colC2*Hspacing)+(Hspacing))-correction,((rowC2*Vspacing)+(Vspacing-Vspacing/4))-correction,
                        (colC1*Hspacing)+correction,(rowC1*Vspacing)+correction);
                }
                else{
                    jg_doc3.drawLine((colC2*Hspacing)+correction,((rowC2*Vspacing)+(Vspacing-Vspacing/4))+correction,
                        ((colC1*Hspacing)+(Hspacing-Hspacing/4))-correction,(rowC1*Vspacing)-correction);
                }
            }
        }
    }

    /*
            jg_doc3.drawLine(110,20,110,60);
            jg_doc3.drawLine(120,15,340,25);
            jg_doc3.drawLine(100,15,15,45);
            jg_doc3.drawPolyline(new Array(400+10,400+10,540+10,540+10), new Array(40,40-5,40-5,40));
        */

    jg_doc3.paint(); // draws, in this case, directly into the document
}

function myDrawFunction4(C1,C2,Hspacing,Vspacing,totalperrow,color,stroke)
{
    /*
         *first position: 0,0
         *last position: (30*20=600),(20*#rows)
         *each horizontal change: +-Hspacing px
         *each vertical change: +-Vspacing px
         *
         *Disulfide Bond between cysteines C1 and C2
         */

    jg_doc4.setColor(color);
    jg_doc4.setStroke(stroke);

    var rowC1 = parseInt(C1/totalperrow);
    var rowC2 = parseInt(C2/totalperrow);
    var colC1 = C1%30;
    var colC2 = C2%30;
    var correction = 0;

    if (rowC1 == rowC2){
        //they are in the same row
        var Xpoints = new Array((colC1*Hspacing)+(Hspacing-Hspacing/2),(colC1*Hspacing)+(Hspacing-Hspacing/2),
            (colC2*Hspacing)+(Hspacing-Hspacing/2),(colC2*Hspacing)+(Hspacing-Hspacing/2));
        var Ypoints = new Array((rowC1*Vspacing),(rowC1*Vspacing)-(Vspacing/4),
            (rowC2*Vspacing)-(Vspacing/4),(rowC2*Vspacing));
        jg_doc4.drawPolyline(Xpoints, Ypoints);
    }
    else{
        //they are in different rows
        if(rowC2 > rowC1){
            if(colC1 == colC2){
                jg_doc4.drawLine((colC1*Hspacing)+(Hspacing-Hspacing/2),(rowC1*Vspacing)+(Vspacing),
                    (colC2*Hspacing)+(Hspacing-Hspacing/2),(rowC2*Vspacing));
            }
            else{
                if(colC2 > colC1){
                    jg_doc4.drawLine(((colC1*Hspacing)+(Hspacing))-correction,((rowC1*Vspacing)+(Vspacing-Vspacing/4))-correction,
                        (colC2*Hspacing)+correction,((rowC2*Vspacing)+(Vspacing-3*Vspacing/4))+correction);
                }
                else{
                    jg_doc4.drawLine((colC1*Hspacing)+correction,((rowC1*Vspacing)+(Vspacing-Vspacing/4))+correction,
                        ((colC2*Hspacing)+(Hspacing-Hspacing/4))-correction,(rowC2*Vspacing)-correction);
                }
            }
        }
        else{
            if(colC2 == colC1){
                jg_doc4.drawLine((colC2*Hspacing)+(Hspacing-Hspacing/2),(rowC2*Vspacing)+(Vspacing),
                    (colC1*Hspacing)+(Hspacing-Hspacing/2),(rowC1*Vspacing));
            }
            else{
                if(colC1 > colC2){
                    jg_doc4.drawLine(((colC2*Hspacing)+(Hspacing))-correction,((rowC2*Vspacing)+(Vspacing-Vspacing/4))-correction,
                        (colC1*Hspacing)+correction,(rowC1*Vspacing)+correction);
                }
                else{
                    jg_doc4.drawLine((colC2*Hspacing)+correction,((rowC2*Vspacing)+(Vspacing-Vspacing/4))+correction,
                        ((colC1*Hspacing)+(Hspacing-Hspacing/4))-correction,(rowC1*Vspacing)-correction);
                }
            }
        }
    }

    /*
            jg_doc4.drawLine(110,20,110,60);
            jg_doc4.drawLine(120,15,340,25);
            jg_doc4.drawLine(100,15,15,45);
            jg_doc4.drawPolyline(new Array(400+10,400+10,540+10,540+10), new Array(40,40-5,40-5,40));
        */

    jg_doc4.paint(); // draws, in this case, directly into the document
}




